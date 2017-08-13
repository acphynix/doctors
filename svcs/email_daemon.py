#!/usr/bin/python

import MySQLdb
import email
import boto3

client = boto3.client('ses')

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

db = MySQLdb.connect(host="localhost",           # your host, usually localhost
                     user="ec2-user",            # your username
                     passwd="",                  # your password
                     db="HealthTechSchema")      # name of the data base

cur = db.cursor()



# cur.execute("""
#     insert into emails
#     (user_id, subject, user_email, content, nature, status, times_sent) values
#     ('163', 'subject line', 'ashwinchetty@gmail.com', '<html><body>Email <i>contents</i>.</body></html>','update','queued','0')
#   """)

# cur.execute("update emails set subject='el sujeto'")
cur.execute("SELECT * FROM emails where status='queued'")


# print all the first cell of all the rows
for row in cur.fetchall():
  cur.execute("update emails set status='lock' where email_id = "+str(row[0]))
  db.commit()
  send_email( [row[3]], [], row[2], row[4])
  cur.execute("update emails set status='sent',times_sent="+str(row[7])+" where email_id = "+str(row[0]))
  print row

db.commit()
db.close()
