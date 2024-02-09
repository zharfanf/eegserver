import argparse
import time
import numpy as np
import csv

import brainflow
from brainflow.board_shim import BoardShim, BrainFlowInputParams
from brainflow.data_filter import DataFilter, FilterTypes, AggOperations
import requests

def saveToCSV(waveformdata):
    with open('dataCyton.csv', 'w', newline='') as csvfile:
        csvwriter = csv.writer(csvfile)
        csvwriter.writerow(['Timestamp', 'Channel 1', 'Channel 2', 'Channel 3', 'Channel 4', 'Channel 5', 'Channel 6', 'Channel 7', 'Channel 8','x','y','z'])
        for line in waveformdata.tolist():
            csvwriter.writerow(line)

def sendDataToServer(eegdata,acceldata,timestampdata,fsampling):
	url='http://192.168.111.212/api.php'
	apikey='ff5f9ee86c6e510749a024415eb05a14'
	print(timestampdata[0])
	datapoints=250
	# timestampdata = timestampdata[0:datapoints]
	# eegdata=[data[0:datapoints] for data in eegdata]
	# acceldata=[data[0:datapoints] for data in acceldata]
	starttimestamp=timestampdata[0]
	endtimestamp=timestampdata[-1]
	waveformdata=np.transpose(np.vstack((timestampdata,eegdata,acceldata)))
	# print(waveformdata)
	saveToCSV(waveformdata)
	jsondata = {'apikey':apikey, 'waveformdata': waveformdata.tolist(),'starttimestamp': starttimestamp, 'endtimestamp':endtimestamp,'datapoints':datapoints,'samplingfreq':fsampling}
	response = requests.post(url, headers={"Date":str(time.time())}, json=jsondata,timeout=5)
	print(response.text)
	return response


def getDataSegment(segmentleninseconds=1):
	board_id=0 #cyton=0
	serial_port='/dev/ttyUSB0'  #in raspberry pi 3+ =/dev/ttyUSB0


	#BoardShim.enable_dev_board_logger()
	BoardShim.disable_board_logger()

	params = BrainFlowInputParams()
	params.serial_port = serial_port
	board = BoardShim(board_id, params)

	board.prepare_session()


	fsampling=board.get_sampling_rate(board_id)
	eegch=board.get_eeg_channels(board_id)
	timestampch=board.get_timestamp_channel(board_id)
	accelch=board.get_accel_channels(board_id)

	segmentlen=segmentleninseconds*fsampling
	board.start_stream(45000)
	time.sleep(2)
	# data = board.get_current_board_data (256) # get latest 256 packages or less, doesnt remove them from internal buffer
	while True:

		if board.get_board_data_count()>segmentlen:

			data = board.get_board_data(segmentlen)  # get all data and remove it from internal buffer
			eegdata=data[eegch]
			timestampdata=data[timestampch]
			acceldata=data[accelch]


			output = None
			output = sendDataToServer(eegdata,acceldata,timestampdata,fsampling)
			# timestampdata = timestampdata[0:100]
			# eegdata=eegdata[0:100][:]
			# acceldata=acceldata[:][0:100]
			# print(len(eegdata[0]))
			# print(timestampdata)
			# print(acceldata)
			time.sleep(5)

			
	board.stop_stream()
	board.release_session()



if __name__ == "__main__":
	getDataSegment()
