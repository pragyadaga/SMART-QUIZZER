'''
	code to be modified.
'''
from nltk.tag import pos_tag
def find_proper_nouns():
	sentence = "Michael Jackson likes to eat at McDonalds. Krishna temple is in a place called Udupi."
	tagged_sent = pos_tag(sentence.split())
	print(tagged_sent)
	# [('Michael', 'NNP'), ('Jackson', 'NNP'), ('likes', 'VBZ'), ('to', 'TO'), ('eat', 'VB'), ('at', 'IN'), ('McDonalds', 'NNP')]

	propernouns = [word for word,pos in tagged_sent if pos == 'NNP']

	print(propernouns)

	# ['Michael','Jackson', 'McDonalds']
'''from nltk.tree import Tree
from nltk.chunk import ne_chunk
l=[chunk for chunk in ne_chunk(tagged_sent) if isinstance(chunk, Tree)]
print(l)
#[Tree('PERSON', [('Michael', 'NNP')]), Tree('PERSON', [('Jackson', 'NNP')]), Tree('PERSON', [('Daniel', 'NNP')])]
p=[i[0] for i in list(chain(*[chunk.leaves() for chunk in ne_chunk(tagged_sent) if isinstance(chunk, Tree)]))]
#['Michael', 'Jackson', 'Daniel']
print(p)'''
if __name__=="__main__":
	find_proper_nouns()
