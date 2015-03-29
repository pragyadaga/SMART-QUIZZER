input1=open("before_test.txt","r")
input2=open("after_test.txt","r")
count=0	#total no of correct answers(marks out of total)
input1.seek(0,0)
dict1={}
for line in input1.readlines():
	list1=[]
	#print(line)
	list1=line.split(",")
	#print(list1)
	dict1[list1[0]]=list1[len(list1)-1]
print(dict1)

dict2={}
for line in input2.readlines():
	list2=[]
	#print(line)
	list2=line.split(",")
	#print(list2)
	dict2[list2[0]]=list2[len(list2)-1]
print(dict2)
dict3={}	#wrong ans
dict4={}	#correct ans
total=len(dict2)	#total no of questions in the test
for i in range(1,total+1):
	i=str(i)
	if(dict1[i]==dict2[i]):
		count+=1
		dict4[i]=dict1[i]
	else:
		dict3[i]=dict2[i]

print("your marks in the test:",count)
print("out of:",total)

print("your correct answers:")
for key,value in dict4.items():
	print(key,dict4[key])

print("your wrong answers:")
for key,value in dict3.items():
	print(key,dict3[key])

print("correct answers should have been:")
for key,value in dict3.items():
	print(key,dict1[key])

input1.close()
input2.close()