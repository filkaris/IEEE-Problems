import sys
import wordmap 

#Get input
data = sys.stdin.readlines()
delim = " ","\n",
dictionary = wordmap.split(delim, data[1] )
times = int(data[2])

print '\n'

#Run each testcase
for i in range(times):
	current = (data[3+i])[:-1]
	print current
	keys = []
	for word in dictionary:
		hackmap = wordmap.bloom( [word] )
		if hackmap.validates(current):
			keys.append(word)
	if len(keys) == 0:
		print 'NONE'
	else:
		keys.sort()
		string =  ' '.join(keys)
		print string
