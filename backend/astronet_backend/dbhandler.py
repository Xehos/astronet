import mysql.connector
import dotenv

class DBHandler:

	def __init__(self,**kwargs):
		try:
			self.db = mysql.connector.connect(
			  host="localhost",
			  user="root",
			  password="root",
			  database="astronet"
			)
		except KeyError:
			raise Exception("DB Connection failed! Check credentials!")

		self.cursor = self.db.cursor()

	def gather_data(self, table, limit=-1,attrs={}):
		objects = []
		if attrs == {}:
			if limit > -1:
				self.cursor.execute("SELECT * FROM {} LIMIT {}".format(table,limit))
			else:
				self.cursor.execute("SELECT * FROM {}".format(table))
		else:
			if limit > -1:
				self.cursor.execute("SELECT * FROM {} WHERE {} = '{}' LIMIT {}".format(table,list(attrs.keys())[0],attrs[list(attrs.keys())[0]],limit))
			else:
				self.cursor.execute("SELECT * FROM {} WHERE {} = '{}'".format(table,list(attrs.keys())[0],attrs[list(attrs.keys())[0]]))
		myresult = self.cursor.fetchall()
		field_names = [i[0] for i in self.cursor.description]
		for x in range(len(myresult)):
			res_dict = {}
			for z in range(len(myresult[x])):
				res_dict[field_names[z]] = myresult[x][z]
			objects.append(res_dict)
		return objects

