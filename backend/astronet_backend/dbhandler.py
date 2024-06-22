import os
import mysql.connector
from dotenv import load_dotenv
from pathlib import Path

dotenv_path = Path(".env")
load_dotenv(dotenv_path=dotenv_path)

class DBHandler:

	def __init__(self,**kwargs):
		pass


	def _init_db(self):
		try:
			self.db = mysql.connector.connect(
			  host=os.environ["MYSQL_HOSTNAME"],
			  user=os.environ["MYSQL_USER"],
			  password=os.environ["MYSQL_PASSWORD"],
			  database=os.environ["MYSQL_DB"]
			)
		except KeyError:
			raise Exception("DB Connection failed! Check credentials!")
		self.cursor = self.db.cursor()


	def _close_db(self):
		self.cursor.close()
		self.db.close()


	def add_number(self, table: str, attrs: dict={}):
		self._init_db()
		print("UPDATE {} SET {} = {} + {} WHERE {} = {}".format(table, 
			attrs["number_col"],attrs["number_col"],attrs["number"],attrs["selector_col"],attrs["selector"]))

		self.cursor.execute("UPDATE {} SET {} = {} + {} WHERE {} = '{}'".format(table, attrs["number_col"],
															attrs["number_col"],attrs["number"],attrs["selector_col"],
															attrs["selector"]))
		self.db.commit()
		self._close_db()

	def gather_data(self, table: str, limit:int=-1 ,attrs: dict={}) -> list:
		self._init_db()
		objects = []
		if attrs == {}:
			if limit > -1:
				self.cursor.execute("SELECT * FROM {} LIMIT {}".format(table,limit))
			else:
				self.cursor.execute("SELECT * FROM {}".format(table))
		else:
			if limit > -1:
				self.cursor.execute("SELECT * FROM {} WHERE {} = '{}' LIMIT {}".format(table,
					list(attrs.keys())[0],attrs[list(attrs.keys())[0]],limit))
			else:
				self.cursor.execute("SELECT * FROM {} WHERE {} = '{}'".format(table,
					list(attrs.keys())[0],attrs[list(attrs.keys())[0]]))

		myresult = self.cursor.fetchall()
		field_names = [i[0] for i in self.cursor.description]
		for x in range(len(myresult)):
			res_dict = {}
			for z in range(len(myresult[x])):
				res_dict[field_names[z]] = myresult[x][z]
			objects.append(res_dict)
		self.db.commit()
		self._close_db()

		return objects


