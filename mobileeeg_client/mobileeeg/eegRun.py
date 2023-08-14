import argparse
import time
import numpy as np
import random
import requests

data_array = []
data_arrays = []
array_random = []
waveformdata=[]
data_array_2d=[]

def readFile (data_array,file_path):
    f = open(file_path, 'r')
    lines = f.readlines()
    data_array = np.array([float(line.strip()) for line in lines])
    return data_array

def randomArray (array_random) :
	for i in range (1,9) :
		x = random.randint(1,100)
		array_random.append(x)
	return array_random
	

def sendDataToServer(data_arrays_2d):
	# url='http://192.168.97.175/api.php'
	# apikey='68d79521339f81b3c90c2a8d631bda5f'
	for i in range(len(data_arrays_2d)):
		waveformdata = np.transpose(np.vstack(data_arrays_2d))
	print(waveformdata.tolist())
	# jsondata = {'apikey':apikey, 'waveformdata': waveformdata.tolist(),'starttimestamp': starttimestamp, 'endtimestamp':endtimestamp,'datapoints':datapoints,'samplingfreq':fsampling}
	# response = requests.post(url, json=jsondata,timeout=5)
	# print(response.text)

array_random=randomArray(array_random)
for i in array_random :
	if (i<10) :
		file_path = f'Z/Z00{i}.txt'
	elif (i<100) :
		file_path = f'Z/Z0{i}.txt'
	else :
		file_path = f'Z/Z{i}.txt'
	data_array = readFile(data_array,file_path)
	data_arrays.append(data_array)


data_array_2d = np.array(data_arrays)
# print(data_array_2d)
sendDataToServer(data_array_2d)
