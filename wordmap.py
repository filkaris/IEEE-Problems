import sys


#delimiter list
delimiters = " ","\n",",",".","?","!"



# Sanitizing string
def split(delimiters, string, maxsplit=0):
	import re
	regex = '|'.join(map(re.escape, delimiters))
	return re.split(regex, string, maxsplit)





class bloom:
	
	def __init__(self, wordlist ):
		
		self.wordlist = wordlist
		self.dictionary = {}
		self.sieve = [False]*26
		# Creating the dictionary
		for (i,letter) in enumerate( 'abcdefghigklmnopqrstuvwxyz'):
			self.dictionary[letter] = i

		self.createFilter()

	def createFilter( self ):

		dictionary = self.dictionary
		words = self.wordlist			
		
		for word in words:
			for letter in word:
				index = dictionary[letter]
				if self.sieve[index] == False:
					self.sieve[index] = True
	

	def validates( self, word ):
		for letter in word:
			index = self.dictionary[letter]
			if self.sieve[index] == False:
				return False
		return True


	def debugme( self ):
		print self.wordlist, self.sieve


if __name__ == '__main__':

	data = sys.stdin.readlines()

	words = split(delimiters, data[0])

	myfilter = bloom( words )

	testwords = split(delimiters, data[1])

	count = 0
	for word in testwords:
		nword = word.lower()
		if myfilter.validates( nword ):
			count +=1

	print '\n'
	print count
