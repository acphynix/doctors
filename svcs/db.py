#!/usr/bin/python

import MySQLdb

db = MySQLdb.connect(host="localhost",           # your host, usually localhost
                     user="ec2-user",            # your username
                     passwd="",                  # your password
                     db="HealthTechSchema")      # name of the data base

# you must create a Cursor object. It will let
#  you execute all the queries you need
cur = db.cursor()

# Use all the SQL you like
cur.execute("SELECT * FROM users")

# print all the first cell of all the rows
for row in cur.fetchall():
    print row

db.close()
