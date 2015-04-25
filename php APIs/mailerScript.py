# Usage python mailerScript.py scheduled <email1> <email2> ... <emailn> <subject> <message> <HH:MM:SS> <MM/DD/YYYY>
#																							   Time        Date
import smtplib
import sys
import os
import random
def sendGmail(toaddrs,subject,message):
	"""toaddrs -> list strings of email addresses to send the mail to
	   subject -> Subject of the mail to be sent
	   message -> message/body of the mail to be sent (Can be formatted With HTML for better appearance)"""
	fromaddr = 'smartquizzer@gmail.com'
	msg = 'Subject: %s\n\n%s' % (subject,message)
	username = 'smartquizzer@gmail.com'
	password = 'smartquizzer111'
	server = smtplib.SMTP('smtp.gmail.com:587')
	server.ehlo()
	server.starttls()
	server.login(username,password)
	server.sendmail(fromaddr, toaddrs, msg)
	server.quit()
if(sys.argv[1]=='scheduled'):
	spacedEmails = " ".join(sys.argv[2:-4])
	print()
	# change the C:\mailerScript.py to the proper location of the script if it is to be moved
	schtaskString = "schtasks /create /tn EmailIt"+str(random.randint(1,10000))+" /tr \"python C:\mailerScript.py "+spacedEmails+" \\\""+sys.argv[-4]+"\\\" \\\""+sys.argv[-3]+"\\\"\" /sc ONCE /st "+sys.argv[-2]+" /sd "+sys.argv[-1]
	os.system(schtaskString)
else:
	sendGmail(sys.argv[1:-2],sys.argv[-2], sys.argv[-1])