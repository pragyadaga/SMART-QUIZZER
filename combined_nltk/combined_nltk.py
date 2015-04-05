import sys
import os
import re
from win32com.client import Dispatch
import summary
import nltk



def paragraphs(file, separator=None):
    # reading file para by para
    if not callable(separator):
        def separator(line): return line == '\n'
    paragraph = []
    for line in file:
        if separator(line):
            if paragraph:
                yield ''.join(paragraph)
                paragraph = []
        else:
            paragraph.append(line)
    yield ''.join(paragraph)

def summary_para(inputfile):
#uses summary class to find generate filename_summary.txt(summary of the pdf/word )  
	name, ext = inputfile.split(".");
	summaryfile = name+"_summary.txt"
	if os.path.exists(summaryfile):
		os.remove(summaryfile)
	try:
		fi = open(inputfile, 'r',encoding="utf8")
		contents = fi.read()
	except Exception as e:
		fi = open(inputfile, 'r')
		contents = fi.read()
	for para in paragraphs(contents):
		try:
			summary.main(summaryfile, para)
		except Exception as e:
			pass
	fi.close()

def main(argv):
	#used for converting pdf/word to text file
    inputfile = argv[0]
    #print(inputfile)
    name, ext = os.path.splitext(inputfile)
    
    # checking file type
    # converting pdf, doc, docx to text file
    if ext == '.pdf' :
        #print("pdf file")
        outputfile = name + '.txt'
        # pdftotext.exe converts pdf to text
        if(len(argv) == 1):
            os.system("G:\Python34\pdftotext.exe \""+inputfile+"\"")
        if(len(argv) == 2):
            first_page_no = argv[1]
            os.system("G:\Python34\pdftotext.exe -f "+first_page_no+" \""+inputfile+"\" \""+outputfile+"\"")
        if(len(argv) == 3):
            first_page_no = argv[1]
            last_page_no = argv[2]
            os.system("G:\Python34\pdftotext.exe -f "+first_page_no+" -l "+last_page_no+" \""+inputfile+"\" \""+outputfile+"\"")
        name, ext = os.path.splitext(inputfile)
        print(outputfile)
    elif ext == '.doc' or ext == '.docx':
        print("doc file")
        wordapp = Dispatch('Word.Application')
        outputfile = name + '.txt'
        #print(outputfile)
        wordapp.Documents.Open(os.path.abspath(inputfile))
        wdFormatTextLineBreaks = 3
        wordapp.ActiveDocument.SaveAs(os.path.abspath(outputfile), FileFormat=wdFormatTextLineBreaks)
        wordapp.ActiveDocument.Close()
    elif ext == '.txt':
        print("Txt file")
        outputfile = inputfile;        
    else : 
        print("File type not supported")

    summary_para(outputfile)
def create_nouns_list(file):
	'''creates a text file of nouns.
	nouns_list.txt is used by function putting_blanks.'''
	#read from file and do pos tagging
	final_read=file[0].split('.')[0]+".txt"
	print(final_read)
	c=open(final_read,"r")
	str=c.read()
	import nltk
	t=nltk.word_tokenize(str)
	#print(t) #words of the text
	tagged=nltk.pos_tag(t)
	#print(tagged) #tagged list of all words of the text

	#get a list of nouns
	nouns=[]
	for i in tagged:
		#print(i)
		if(i[1]=="NN"):
			nouns.append(i[0])
	#print(nouns) #list of all nouns in the text(nouns repeat)
	nouns_set=set(nouns)
	f=open("nouns_list.txt","w")
	for noun in nouns_set:
		f.write(noun+"\n")
# from nltk.corpus import brown
def create_preposition_list(file):
	'''creates a text file of prepositions.
	preposition_list.txt is used by function putting_blanks.'''
	final_read=file[0].split('.')[0]+".txt"
	#print(final_read)
	fp_read=open(final_read,"r")
	fp_read_file=fp_read.read()
	t=nltk.word_tokenize(fp_read_file)
	tag_words=nltk.pos_tag(t)
	preposition=[]
	for i in tag_words:
		if(i[1]=='IN'):
			res=""
			for j in i[0]:
				if((j!=' ') or (j!='\n')):
					res+=j
			if res not in preposition:
				preposition.append(res)


	fp_write=open("preposition_list.txt","w")
	for i in preposition:
		s=i+"\n"
		fp_write.write(s)
def putting_blanks(file): 
	'''called in main if teacher doesnt provide glossary file along with pdf/word file. 
						  generates FITB based on nouns and prepositions approach.'''
	final_read=file[0].split('.')[0]+".txt"
	final_read_summary=file[0].split('.')[0]+"_summary"+".txt"
	fp_story=open(final_read,"r")
	fp_story_summary=open(final_read_summary,"r")
	fp_list_of_nouns=open("nouns_list.txt","r")
	fp_question_file=open("question.txt","w")
	fp_preposition_list=open("preposition_list.txt","r")
	line_story_=fp_story.read()
	line_story_summary_=fp_story_summary.read()
	line_story=line_story_.split('.')
	line_story_summary=line_story_summary_.split('.')
	list_of_nouns=fp_list_of_nouns.readlines()
	list_of_preposition=fp_preposition_list.readlines()
	#print(list_of_preposition)
	list_of_preposition_=[]
	dict_outer={}
	value_list=[]
	for i in list_of_preposition:

		k=i.split('\n')
		#print(k[0])
		list_of_preposition_.append(k[0])
	#print(list_of_preposition_)
	# print(list_of_nouns)
	# print(1000-len(list_of_nouns))
	for i in list_of_nouns:
		# print(i)
		for line in line_story:
			s=line.split(" ")
			# print(s)
			# print(len(s))
			k=i.split('\n')
			if k[0] in s:
				c=line.index(k[0])
				if(len(s)>=5 and len(s)<=15):
					# if(k[0][0].isupper()):

					if((c<=(len(s[0])+len(s[1])+len(s[3])+len(s[3]))) or (c>=(len(s)-(len(s[len(s)-1])+len(s[len(s)-2])+len(s[len(s)-3])+len(s[len(s)-4]))))):
						word_index=0
						for j in range(len(s)):
							if(s[j]==k[0]):
								word_index=j
						if((word_index!=0) and (word_index!=(len(s)-2)) and (word_index!=(len(s)-1))):
							if((s[word_index-1] in list_of_preposition_) or (s[word_index+1] in list_of_preposition_)):
								new_sentence=re.sub(k[0],"_________",line)
								new_sentence=new_sentence+" .\n"
								#fp_question_file.write(new_sentence)
								dict_inner={}
								dict_inner["ques"]=new_sentence
								dict_inner["ans"]=k[0]
								value_list.append(dict_inner)
								#print(new_sentence)
								#print(value_list)
	dict_outer["question"]=value_list
	print(dict_outer)
'''		for line in line_story_summary:
				s=line.split(" ")
				# print(s)
				# print(len(s))
				k=i.split('\n')
				if k[0] in s:
					c=line.index(k[0])
					if(len(s)>=5 and len(s)<=15):
						# if(k[0][0].isupper()):

						if((c<=(len(s[0])+len(s[1])+len(s[3])+len(s[3]))) or (c>=(len(s)-(len(s[len(s)-1])+len(s[len(s)-2])+len(s[len(s)-3])+len(s[len(s)-4]))))):
							word_index=0
							for j in range(len(s)):
								if(s[j]==k[0]):
									word_index=j
							if((word_index!=0) and (word_index!=(len(s)-2)) and (word_index!=(len(s)-1))):
								if((s[word_index-1] in list_of_preposition_) or (s[word_index+1] in list_of_preposition_)):
									new_sentence=re.sub(k[0],"_________",line)
									new_sentence=new_sentence+" .\n"
									#fp_question_file.write(new_sentence)
									print(new_sentence)	
'''
def find_from_glossary(file): 
	'''called in main when teacher provides glossary of keywords along with pdf/word file'''
	glossary_file=file[0].split('.')[0]+"_glossary"+".txt"
	input_file=file[0].split('.')[0]+".txt"
	c=open(input_file,"r")
	g=open(glossary_file,"r")
	str=c.read()
	#print("hello\n")
	q=open("questions.txt","w")
	l=str.split('.')

	p=g.readlines()
	keywords=[]
	
	for i in p:
		keywords.append(i.split("\n")[0])
		#print(keywords)
	for i in keywords:
		for sentence in l:
			#print(sentence)
			s=sentence.split(" ")
			
			if i in s:
				#print("found")
				new_sentence=re.sub(i,"_____",sentence)
				#print(new_sentence)
				new_sentence=new_sentence+" .\n"
				#q.write(new_sentence)
				print(new_sentence)
if __name__ == "__main__":
	main(sys.argv[1:])
	create_nouns_list(sys.argv[1:])
	create_preposition_list(sys.argv[1:])
	if os.path.exists('F:\\6th_SEM\\se_code\\C_glossary'): #if the glossary is provided by teacher
		find_from_glossary(sys.argv[1:])
		print("hi\n")
	else:												#if glossary is not provided by teacher
		putting_blanks(sys.argv[1:])