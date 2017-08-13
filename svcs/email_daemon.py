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

def send_email( send_to, send_bcc, subject, body_html ):
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
    ReplyToAddresses=['neolafia@neolafia.com'],
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
    curr_status = qget("select status from appointments where appointment_id="+appt_id)[0]
    if status != curr_status:
      qget("update appointments set status='"+status+"' where appointment_id="+appt_id)
      IDs = qget("select doctor_id, patient_id from appointments where appointment_id="+appt_id)
      email_data = str(appt_id)+'|'+IDs[0]+'|'+IDS[1]
      qget("insert into emails (user_id, email_type, data) values ('" + IDs[0] + "', '" + 'doctor_appointment_'  + status + "', '"+email_data+"') ")
      qget("insert into emails (user_id, email_type, data) values ('" + IDs[1] + "', '" + 'patient_appointment_' + status + "', '"+email_data+"') ")

# process actions

actions = qget("SELECT action_id,action_exec,silent FROM actions where action_status='queued'")
for row in actions:
  cmd = row[1].split(' ')
  if(cmd[0] == 'Verify-Doctor'):
    try:
      id = int(cmd[0])
      qget("update doctors set doctor_cert_status='verified' where user_id="+id)
    except:
      continue
  elif(cmd[0] == 'Appt-Status'):
    try:
      appt_id = int(cmd[0])
      status  = cmd[1]
      queue_appt_transition_to(appt_id, status)

    except:
      continue
  else:
    continue

qget("update actions set action_status='complete'")

# get new emails

new_emails = qget("SELECT email_id, user_id, email_type, email_idata FROM emails where email_status='new'")
for row in new_emails:
  uid   = row[1]
  etype = row[2]
  idata = row[3]

  # check that this is a supported email type
  if etype in ['patient_account_new', 'doctor_account_new', 'doctor_appointment_pending']:
    with open('/var/www/html/email/' + etype + '.html', 'r') as file:
      content = file.read()
  else:
    continue

  # collect fields for email template interpolation
  fields_tt = qget("SELECT user_first_name, user_last_name, verify_code, user_email FROM users left join email_verify on (users.user_id = email_verify.user_id) where users.user_id='"+str(uid)+"'")
  if etype in ['patient_appointment_pending, doctor_appointment_pending']:
    appt_id,doctor_id,patient_id = idata.split('|')
    fields_dr = qget("SELECT user_first_name, user_last_name from users where user_id='" + doctor_id  + "'")
    fields_pt = qget("SELECT user_first_name, user_last_name from users where user_id='" + patient_id + "'")

  content = content.replace('{{fullname}}'          , str(fields_tt[0][0]) + ' ' + str(fields_tt[0][1]))
  content = content.replace('{{patient.fullname}}'  , str(fields_pt[0][0]) + ' ' + str(fields_pt[0][1]))
  content = content.replace('{{patient.firstname}}' , str(fields_pt[0][0]))
  content = content.replace('{{doctor.fullname}}'   , str(fields_dr[0][0]) + ' ' + str(fields_dr[0][1]))
  content = content.replace('{{doctor.firstname}}'  , str(fields_dr[0][0]))
  content = content.replace('{{link_authenticate}}' , 'https://www.neolafia.com/verify_acct.php?q='+str(fields_tt[0][2]))
  content = content.replace('\\', '\\\\')
  content = content.replace('\'', '\\\'')

  subject = fields_tt[0][3]+': '+'Welcome to Neolafia!'
  email   = fields_tt[0][3]
   
  email='ashwinchetty@gmail.com'

  cur.execute("update emails set email_status='queued',user_email='"+email+
              "', subject='"+subject+"', content='"+content+
              "' where email_id = "+str(row[0]))
  db.commit()
  print row

cur.execute("SELECT email_id, user_email, subject, content, times_sent FROM emails where email_status='queued'")
for row in cur.fetchall():
  cur.execute("update emails set email_status='processing' where email_id = "+str(row[0]))
  db.commit()
  send_email( [row[1]], [], row[2], row[3])
  cur.execute("update emails set email_status='sent',times_sent="+str(row[4]+1)+" where email_id = "+str(row[0]))
  print row

db.commit()
db.close()
