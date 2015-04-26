######## To notify the students when the quiz is scheduled
import smtplib
import sys
import os
import random


fromaddr = 'smartquizzer@gmail.com'
toaddrs=sys.argv[1].split(':')
msg = 'Subject: Quiz has been scheduled \n\n'
msg+=sys.argv[2]

username = 'smartquizzer@gmail.com'
password = 'smartquizzer111'
server = smtplib.SMTP('smtp.gmail.com:587')
server.ehlo()
server.starttls()
server.login(username,password)
server.sendmail(fromaddr, toaddrs, msg)
server.quit()