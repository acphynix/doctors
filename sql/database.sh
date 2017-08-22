#!/bin/bash
for i in `ls *.sql | sort -V`; do
  echo $i;
  mysql -u ec2-user HealthTechSchema < $i
done;