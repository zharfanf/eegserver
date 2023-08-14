import argparse
import time
import numpy as np
import random
import requests

def readFile (data_array,file_path):
    f = open(file_path, 'r')
    lines = f.readlines()
    data_array = np.array([float(line.strip()) for line in lines])
    return data_array

def randomArraydata (array_random_file) :
	for i in range (1,9) :
		x = random.randint(1,100)
		array_random_file.append(x)
	return array_random_file

def randomArraytime (starttimestamp) :
	# 25 detik, 4096 data -> 25/4096
	for i in range (4097) :
		timestampdata.append(starttimestamp + (i * (25/4097)))
	return timestampdata

def sendDataToServer(data_array_2d,timestampdata):
	url='http://192.168.175.212/api.php'
	apikey='ff5f9ee86c6e510749a024415eb05a14'
	datapoints=4096
	starttimestamp=timestampdata[0]
	endtimestamp=timestampdata[-1]
	waveformdata = np.transpose(np.vstack((timestampdata, data_array_2d)))
	print(waveformdata.tolist())
	jsondata = {'apikey':apikey, 'waveformdata': waveformdata.tolist(),'starttimestamp': starttimestamp, 'endtimestamp':endtimestamp,'datapoints':datapoints,'samplingfreq':174}
	response = requests.post(url, json=jsondata,timeout=5)
	print(response.text)

while True :
	data_array = []
	data_arrays = []
	timestampdata = []
	array_random_file = []
	waveformdata=[]
	data_array_2d=[]
	array_random_file=randomArraydata(array_random_file)
	timestampdata=randomArraytime(time.time())
	for i in array_random_file :
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
	sendDataToServer(data_array_2d, timestampdata)
	time.sleep(60)
