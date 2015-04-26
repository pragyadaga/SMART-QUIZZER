import smtplib
import sys
import os
import random


fromaddr = 'smartquizzer@gmail.com'
toaddrs='prabhat.sirsi@gmail.com'
msg = 'Subject: Feedback \n\n'
msg+="From : "+sys.argv[1]+" Message : "+sys.argv[2]

username = 'smartquizzer@gmail.com'
password = 'smartquizzer111'
server = smtplib.SMTP('smtp.gmail.com:587')
server.ehlo()
server.starttls()
server.login(username,password)
server.sendmail(fromaddr, toaddrs, msg)
server.quit()