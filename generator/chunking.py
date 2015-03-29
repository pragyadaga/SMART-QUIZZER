'''
	code to be modified.
'''
import nltk
def chunk():
	sentence = [("the", "DT"), ("little", "JJ"), ("yellow", "JJ"), ("dog", "NN"), ("barked",
	"VBD"), ("at", "IN"), ("the", "DT"), ("cat", "NN")]
	pattern = "NP: {<DT>?<JJ>*<NN>}" 
	NPChunker = nltk.RegexpParser(pattern)
	result = NPChunker . parse(sentence)
	print(result)#works

'''str="C was invented by Dennis-Ritchie"
t=nltk.word_tokenize(str)
#print(t) #words of the text
tagged=nltk.pos_tag(t)
print(tagged)
pattern="NP: {<DT>?<JJ>*<NN>}"
NPChunker = nltk.RegexpParser(pattern)
result = NPChunker.parse(str)
print(result)'''
if __name__=="__main__":
	chunk()