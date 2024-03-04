#!/usr/bin/env python
# coding: utf-8

# In[11]:


from transformers import AutoTokenizer, AutoModelForSequenceClassification
import torch
import requests
from bs4 import BeautifulSoup
import re
from collections import Counter
import matplotlib.pyplot as plt
list_s=[]
tokenizer = AutoTokenizer.from_pretrained('nlptown/bert-base-multilingual-uncased-sentiment')
model = AutoModelForSequenceClassification.from_pretrained('nlptown/bert-base-multilingual-uncased-sentiment')
with open('demofile.txt', 'r') as file:
        for line in file:
            tokens = tokenizer.encode(line.strip(), return_tensors='pt')
            result = model(tokens)
            result.logits
            list_s.append(int(torch.argmax(result.logits))+1)

w = Counter(list_s)
def write_dict_to_file(dictionary, filename):
    with open(filename, 'w') as file:
            for key, value in dictionary.items():
                file.write(f"{key}:{value}\n")
write_dict_to_file(w,'C:/xampp/htdocs/Pidev/public/res.txt')

