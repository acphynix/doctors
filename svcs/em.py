#!/usr/bin/python

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

send_email( ['ashwinchetty@gmail.com'], [], 'test email', '<html><body><p>this is <b>bolded</b> text.</p></body></html>')

