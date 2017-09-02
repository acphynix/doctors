#!/usr/bin/python

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

send_email( ['vjovict@gmail.com'], [], 'test email', '<html><body><p>this is <b>bolded</b> text.</p></body></html>')

