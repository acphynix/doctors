#!/usr/bin/python

import MySQLdb
import email
import boto3

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

def qget(query):
  cur.execute(query)
  return cur.fetchall()  

# get new emails

new_emails = qget("SELECT * FROM emails where email_status='new'")
for row in new_emails:
  uid   = row[1]
  etype = row[2]

  if(etype == 'patient_account_new'):
    with open('/var/www/html/email/'+etype+'.html', 'r') as file:
      content=file.read().replace('\n', ' ')
    fields = qget("SELECT user_first_name, user_last_name, verify_code, user_email FROM users left join email_verify on (users.user_id = email_verify.user_id) where users.user_id='"+str(uid)+"'")
    content = content.replace('{{fullname}}', str(fields[0][0])+' '+str(fields[0][1]))
    content = content.replace('{{link_authenticate}}', 'https://www.neolafia.com/verify_acct.php?q='+str(fields[0][2]))
    content = content.replace('\\', '\\\\')
    content = content.replace('\'', '\\\'')
    subject = fields[0][3]+': '+'Welcome to Neolafia!'
    email='ashwinchetty@gmail.com'

  else:
    continue
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
