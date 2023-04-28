import argparse
import time
import numpy as np
import csv

import brainflow
from brainflow.board_shim import BoardShim, BrainFlowInputParams
from brainflow.data_filter import DataFilter, FilterTypes, AggOperations
import requests



def sendDataToServer(eegdata,acceldata,timestampdata,fsampling):
	starttimestamp=timestampdata[0]
	endtimestamp=timestampdata[-1]
	datapoints=len(timestampdata)
	waveformdata=np.transpose(np.vstack((timestampdata,eegdata,acceldata)))

def getDataSegment(segmentleninseconds=5):
	board_id=0 #cyton=0
	serial_port='/dev/cu.usbserial-DM03H5DJ'  #in raspberry pi 3+ =/dev/ttyUSB0


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
	while True :

		if board.get_board_data_count()>segmentlen:
			data = board.get_board_data(segmentlen)  # get all data and remove it from internal buffer
			eegdata=data[eegch]
			timestampdata=data[timestampch]
			acceldata=data[accelch]
            

			sendDataToServer(eegdata,acceldata,timestampdata,fsampling)
			print(eegch)
			print(len(eegdata[0]))
			for x in data:
				for i in x :
					print(i, end = " ")
				print() 
			
			#print(eegdata)
			#print(timestampdata)
			#print(acceldata)
			time.sleep(0.5)
			
	board.stop_stream()
	board.release_session()



if __name__ == "__main__":
	getDataSegment()
