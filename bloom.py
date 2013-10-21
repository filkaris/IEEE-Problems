import sys


#delimiter list
delimiters = " ","\n",",",".","?","!"


# check if word belongs to the filter
def bloom_valid( word ):
	for letter in word:
		index = dictionary[letter]
		if bloom[index] == False:
			return False
	return True
		

# Sanitizing string
def split(delimiters, string, maxsplit=0):
	import re
	regex = '|'.join(map(re.escape, delimiters))
	return re.split(regex, string, maxsplit)


# Initializing bloom filter
bloom = [False]*26
dictionary = {} 

# Fill the filter
def bloom_init( words ):
	for word in words:
		for letter in word:
			index = dictionary[letter]
			if bloom[index] == False:
				bloom[index] = True


# Mapping numbers to letter to acces the filter
for (i,letter) in enumerate( 'abcdefghigklmnopqrstuvwxyz'):
	dictionary[letter] = i

# Interpret input
data = sys.stdin.readlines()
words = split(delimiters, data[0])

# Calculate and shiit
bloom_init( words )
testwords = split(delimiters, data[1])
count = 0
for word in testwords:
	nword = word.lower()
	if bloom_valid( nword ):
		count +=1

print '\n'
print count
