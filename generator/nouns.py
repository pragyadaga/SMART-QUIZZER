'''
	input file: se_para.txt
	nouns file: nouns_list.txt
	output questions : question.txt
'''
import sys
nouns=[]

#read from file and do pos tagging
c=open("se_para.txt","r")
str=c.read()
import nltk
t=nltk.word_tokenize(str)
#print(t) #words of the text
tagged=nltk.pos_tag(t)
#print(tagged) #tagged list of all words of the text

#get a list of nouns
for i in tagged:
	#print(i)
	if(i[1]=="NN"):
		nouns.append(i[0])
#print(nouns) #list of all nouns in the text(nouns repeat)

nouns_set=set(nouns)
f=open("nouns_list.txt","w")
for noun in nouns_set:
	f.write(noun+"\n")
	
	

#find frequency of every noun in list nouns
from nltk.probability import FreqDist
fdist=FreqDist(nouns);
noun_freq_list=sorted(fdist.items(),key=lambda x: x[1],reverse=True)
#print(noun_freq_list) #list of nouns with their frequencies

import re

q=open("question.txt","w")
l=str.split('.')
#print(l)
noun_set=set(nouns)
#print(noun_set)
for i in noun_set:
	for sentence in l:
		s=sentence.split(" ")
		if i in s:
			#print("found!!")
			new_sentence=re.sub(i,"_____",sentence)
			#print(new_sentence)
			new_sentence=new_sentence+".\n"
			q.write(new_sentence)

