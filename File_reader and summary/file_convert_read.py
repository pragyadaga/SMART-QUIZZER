import sys
import os
import re
from win32com.client import Dispatch
import summary

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
    inputfile = argv[0]
    #print(inputfile)
    name, ext = os.path.splitext(inputfile)
    
    # checking file type
    # converting pdf, doc, docx to text file
    if ext == '.pdf' :
        print("pdf file")
        outputfile = name + '.txt'
        # pdftotext.exe converts pdf to text
        if(len(argv) == 1):
            os.system("C:\Python34\pdftotext.exe \""+inputfile+"\"")
        if(len(argv) == 2):
            first_page_no = argv[1]
            os.system("C:\Python34\pdftotext.exe -f "+first_page_no+" \""+inputfile+"\" \""+outputfile+"\"")
        if(len(argv) == 3):
            first_page_no = argv[1]
            last_page_no = argv[2]
            os.system("C:\Python34\pdftotext.exe -f "+first_page_no+" -l "+last_page_no+" \""+inputfile+"\" \""+outputfile+"\"")
        name, ext = os.path.splitext(inputfile)
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
        outputfile = inputfile;        
    else : 
        print("File type not supported")

    summary_para(outputfile)

if __name__ == "__main__":
    main(sys.argv[1:])