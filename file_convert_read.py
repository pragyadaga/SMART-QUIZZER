import sys
import os
import re
from win32com.client import Dispatch
import summary

def summarize_text_file(outputfile):
    # calls the summarizer
    try:
        f = open(outputfile, 'r')
        title = f.readline()
        contents = f.read()
        f.close()
        try:
            summary.main(title, contents)
        except Exception as e:
            print("There was an error while summarizing the file ")
    except Exception as f:
        print("There was an error while reading the file ")
    #f = open(outputfile, 'r')

def read_text_files(outputfile):
    pass

def main(argv):
    inputfile = argv[0]
    #print(inputfile)
    name, ext = os.path.splitext(inputfile)
    
    # checking file type
    # converting pdf, doc, docx to text file
    if ext == '.pdf' :
        print("pdf file")
        # pdftotext.exe converts pdf to text
        os.system("C:\Python34\pdftotext.exe \""+inputfile+"\"")
        outputfile = name + '.txt'
        print(outputfile)
    elif ext == '.doc' or ext == '.docx':
        print("doc file")
        wordapp = Dispatch('Word.Application')
        outputfile = name + '.txt'
        print(outputfile)
        wordapp.Documents.Open(os.path.abspath(inputfile))
        wdFormatTextLineBreaks = 3
        wordapp.ActiveDocument.SaveAs(os.path.abspath(outputfile), FileFormat=wdFormatTextLineBreaks)
        wordapp.ActiveDocument.Close()
    elif ext == '.txt':
        print("Txt file")
        outputfile = name+"_modified.txt"
        fi = open(inputfile, 'r',encoding="utf8")
        fo = open(outputfile, 'w')
        contents = fi.read()
        fo.write(contents.encode('cp850', errors='replace').decode('utf8', 'ignore'))
        fo.close()
        fi.close()
        print(outputfile)
    else : 
        print("File type not supported")

    #summarize_text_file(outputfile)
    #read_text_file(outputfile)

if __name__ == "__main__":
    main(sys.argv[1:])