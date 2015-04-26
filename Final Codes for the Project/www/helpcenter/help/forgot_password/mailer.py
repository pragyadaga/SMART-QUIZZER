import smtplib
import sys
import os
import random


fromaddr = 'smartquizzer@gmail.com'
toaddrs=sys.argv[1]
msg = 'Subject: Your Smart Quizzer Password \n\n'
msg+="Your Smart Quizzer password is : "+sys.argv[2]

username = 'smartquizzer@gmail.com'
password = 'smartquizzer111'
server = smtplib.SMTP('smtp.gmail.com:587')
server.ehlo()
server.starttls()
server.login(username,password)
server.sendmail(fromaddr, toaddrs, msg)
server.quit()