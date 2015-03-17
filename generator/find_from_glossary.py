'''
	Run as python.exe find_glossary.py input_file.txt glossary_file.txt question_file.txt
	E.g. python.exe find_from_glossary.py c_prgming.txt glossary.txt question.txt
'''
import re
import sys
def find_from_glossary(input_file,glossary_file,question_file):
	c=open(input_file,"r")
	g=open(glossary_file,"r")
	str=c.read()

	
	q=open(question_file,"w")
	l=str.split('.')

	p=g.readlines()
	keywords=[]
	for i in p:
		keywords.append(i.split("\n")[0])
		
	for i in keywords:
		for sentence in l:
			#print(sentence)
			s=sentence.split(" ")
			
			if i in s:
				#print("found")
				new_sentence=re.sub(i,"_____",sentence)
				#print(new_sentence)
				new_sentence=new_sentence+".\n"
				q.write(new_sentence)
if __name__=="__main__":
	find_from_glossary(sys.argv[1],sys.argv[2],sys.argv[3])

			