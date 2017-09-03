#!/usr/bin/python

import MySQLdb
import email
import boto3
import os.path

client = boto3.client('ses', 
          region_name='us-east-1',
          aws_access_key_id='AKIAI3P25I4PQWG2S7QQ',
          aws_secret_access_key='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'
        )

def send_email( send_from, send_to, send_bcc, subject, body_html ):
  response = client.send_email(
    Source='neolafia@neolafia.com',
    Destination={
      'ToAddresses' : send_to,
      'CcAddresses' : [],
      'BccAddresses': send_bcc
    },
    Message={
      'Subject': {
        'Data': subject,
        'Charset': 'utf-8'
      },
      'Body': {
        'Html': {
          'Data': body_html,
          'Charset': 'utf-8'
        }
      }
    },
    ReplyToAddresses=[send_from],
    ReturnPath='neolafia@neolafia.com',
  )

  return response

db = MySQLdb.connect(
  host="localhost",
  user="ec2-user",
  passwd="",
  db="HealthTechSchema")
cur = db.cursor()

# helper functions

def qget(query):
  cur.execute(query)
  return cur.fetchall()  

def queue_appt_transition_to(appt_id, status):
  if status in ['pending','paid','cancelled','approved','withdrawn','complete','closed']:
    curr_status = qget("select status from appointments where appointment_id="+str(appt_id))[0]
    print 'go'
    if status != curr_status:
      print('diff')
      qget("update appointments set status='"+status+"' where appointment_id="+str(appt_id))
      print 'bear'
      IDs = qget("select doctor_id, patient_id from appointments where appointment_id="+str(appt_id))
      print 'hippo'
      print IDs
      print appt_id
      print str(IDs[0][0])
      email_data = str(appt_id)+'|'+str(IDs[0][0])+'|'+str(IDs[0][1])
      print 'yell'
      qget("insert into emails (user_id, email_type, email_idata) values ('" + str(IDs[0][0]) + "', '" + 'doctor_appointment_'  + status + "', '"+email_data+"') ")
      qget("insert into emails (user_id, email_type, email_idata) values ('" + str(IDs[0][1]) + "', '" + 'patient_appointment_' + status + "', '"+email_data+"') ")

# process actions

actions = qget("SELECT action_id,action_exec,silent FROM actions where action_status='queued'")
for row in actions:
  cmd = row[1].split(' ')
  if(cmd[0] == 'Verify-Doctor'):
    try:
      id = int(cmd[1])
      qget("update doctors set doctor_cert_status='verified' where user_id='"+str(id)+"'")
      db.commit()
    except:
      continue
  elif(cmd[0] == 'Appt-Status'):
    print '1'
    try:
      print '2'
      appt_id = int(cmd[1])
      status  = cmd[2]
      queue_appt_transition_to(appt_id, status)
      print 'done'
    except:
      continue
  else:
    continue
print 'out'

qget("update actions set action_status='complete'")
db.commit()

# get new emails

new_emails = qget("SELECT email_id, user_id, email_type, email_idata FROM emails where email_status='new'")
for row in new_emails:
  uid   = row[1]
  etype = row[2]
  idata = row[3]
  # check that this is a supported email type
  if etype in ['doctor_account_new', 'doctor_appointment_pending', 'doctor_appointment_paid', 
               'doctor_appointment_cancelled', 'doctor_appointment_approved', 'doctor_appointment_withdrawn',
               'doctor_appointment_complete', 'doctor_appointment_closed', 'patient_account_new', 
               'patient_appointment_pending', 'patient_appointment_paid', 'patient_appointment_cancelled',
               'patient_appointment_approved', 'patient_appointment_withdrawn', 'patient_appointment_complete',
               'patient_appointment_closed', 'user_account_passwordreset', 'app_user_feedback']:
    try:
      with open('/var/www/html/email/' + etype + '.html', 'r') as file:
        content = file.read()
    except:
      print 'no email template: '+etype
      continue
  else:
    continue
  print 'good'
  # collect fields for email template interpolation
  fields_fb = [['','','','','','']]
  fields_dr = [['','','','','','']]
  fields_pt = [['','','','','','']]
  fields_tt = qget("SELECT user_first_name, user_last_name, verify_code, user_email FROM users left join email_verify on (users.user_id = email_verify.user_id) where users.user_id='"+str(uid)+"'")
  fields_kr = qget("SELECT user_first_name, user_last_name, reset_code, user_email FROM users left join password_reset on (users.user_id = password_reset.user_id) where users.user_id='"+str(uid)+"'")
  print 'email'
  print etype
  if etype in ['doctor_appointment_pending', 'doctor_appointment_paid', 'patient_appointment_paid',
               'patient_appointment_approved', 'doctor_appointment_approved', 'doctor_appointment_closed']:
    appt_id,doctor_id,patient_id = idata.split('|')
    print 'in if'
    fields_dr = qget("SELECT user_first_name, user_last_name from users where user_id='" + doctor_id  + "'")
    fields_pt = qget("SELECT user_first_name, user_last_name from users where user_id='" + patient_id + "'")
  if (etype == 'app_user_feedback'):
	fields_fb = qget("SELECT user_first_name, user_email, content FROM users_feedback where user_feedback_id='"+str(uid)+"'")
  if (etype == 'app_user_feedback'):
    fields_tt = [['','','','','','']]
    fields_kr = [['','','','','','']]
	
  content = content.replace('{{fullname}}'          , str(fields_tt[0][0]) + ' ' + str(fields_tt[0][1]))
  content = content.replace('{{patient.fullname}}'  , str(fields_pt[0][0]) + ' ' + str(fields_pt[0][1]))
  content = content.replace('{{patient.firstname}}' , str(fields_pt[0][0]))
  content = content.replace('{{doctor.fullname}}'   , str(fields_dr[0][0]) + ' ' + str(fields_dr[0][1]))
  content = content.replace('{{doctor.firstname}}'  , str(fields_dr[0][0]))
  content = content.replace('{{link_profile}}'      , 'https://neolafia.com/home.php')
  content = content.replace('{{link_authenticate}}' , 'https://neolafia.com/verify_acct.php?q='+str(fields_tt[0][2]))
  content = content.replace('{{link_passreset}}' 	, 'https://neolafia.com/reset_pass.php?q='+str(fields_kr[0][2]))
  content = content.replace('{{userfirstname}}' 	, str(fields_fb[0][0]))
  content = content.replace('{{usermsg}}' 			, str(fields_fb[0][2]))
  content = content.replace('\\', '\\\\')
  content = content.replace('\'', '\\\'')

  subjects =  {
       'patient_account_new'           : 'Welcome to Neolafia!'
     , 'doctor_account_new'            : 'Welcome to Neolafia!'
     , 'user_account_passwordreset'    : 'Password Reset!'
     , 'patient_appointment_pending'   : 'Thank you for requesting an appointment with Neolafia!'
     , 'doctor_appointment_pending'    : 'A patient is interested in booking an appointment with you!'
     , 'patient_appointment_paid'      : 'We have received your payment!'
     , 'doctor_appointment_paid'       : (str(fields_pt[0][0])+' '+str(fields_pt[0][1])+' has booked an appointment with you!')
     , 'patient_appointment_approved'  : 'Your appointment has been approved!'
     , 'doctor_appointment_approved'   : 'Appointment Confirmation'
     , 'patient_appointment_cancelled' : 'Appointment Cancellation'
     , 'doctor_appointment_cancelled'  : 'Appointment Cancellation'
     , 'patient_appointment_withdrawn' : 'Your appointment has been withdrawn'
     , 'doctor_appointment_withdrawn'  : 'Appointment Withdrawal Notification'
     , 'patient_appointment_complete'  : 'Thank you for choosing Neolafia!'
     , 'doctor_appointment_complete'   : 'Appointment Payment Confirmation'
     , 'patient_appointment_closed'    : 'Thank you for choosing Neolafia!'
     , 'doctor_appointment_closed'     : 'Appointment Payment Confirmation'
     , 'app_user_feedback'     	       : 'User Feedback!'
    }

  subject = subjects[etype]
  if(etype=='user_account_passwordreset'):
	email   = fields_kr[0][3]
	print 'sending '+subject+' to '+email
  elif(etype=='app_user_feedback'):
	email   = fields_fb[0][1]
	print 'sending '+subject+' from '+email
  else:
	email   = fields_tt[0][3]
	print 'sending '+subject+' to '+email
   
  # subject = fields_tt[0][3]+': '+subjects[etype]
  # email='ashwinchetty@gmail.com'

  cur.execute("update emails set email_status='queued',user_email='"+email+
              "', subject='"+subject+"', content='"+content+
              "' where email_id = "+str(row[0]))
  print 'sent!'
  db.commit()
  # print row

cur.execute("SELECT email_id, user_email, subject, content, times_sent FROM emails where email_status='queued'")
for row in cur.fetchall():
  cur.execute("update emails set email_status='processing' where email_id = "+str(row[0]))
  db.commit()
  if(row[2] == 'User Feedback!'):
	send_email(  'neolafia@neolafia.com', 'vjovict@gmail.com', [], row[2], row[3])
  else:
	send_email( 'neolafia@neolafia.com', [row[1]], [], row[2], row[3])
  cur.execute("update emails set email_status='sent',times_sent="+str(row[4]+1)+" where email_id = "+str(row[0]))
  # print row

db.commit()
db.close()
