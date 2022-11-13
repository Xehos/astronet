from flatlib.datetime import Datetime
from flatlib.geopos import GeoPos
from flatlib.chart import Chart
# from flatlib import const
from flatlib import angle

from . import const as ac_const

import pytz
import datetime
import timezonefinder


class AstralCompass(object):
    def __init__(self, **kwargs):
        self.objects, self.houses, self.gender_ratio,\
            self.modality_ratio, self.elements_ratio = [], [], (0, 0), (0, 0, 0), (0, 0, 0, 0)
        try:
            self.lon = kwargs["longitude"]
        except KeyError:
            raise Exception("Longitude not set!")

        try:
            self.lat = kwargs["latitude"]
        except KeyError:
            raise Exception("Latitude not set!")

        try:
            self.date = kwargs["date"]
        except KeyError:
            raise Exception("Date not set!")

        try:
            self.time = kwargs["time"]
        except KeyError:
            raise Exception("Time not set!")
        self.create_chart()

    @staticmethod
    def find_offset(lat, lon) -> str:
        """
        :param lat: Latitude
        :param lon: Longitude
        :return: UTC offset of the place
        """
        tf = timezonefinder.TimezoneFinder()
        timezone_str = tf.certain_timezone_at(lat=lat, lng=lon)
        pacific_now = datetime.datetime.now(pytz.timezone(timezone_str))
        offset_fl = pacific_now.utcoffset().total_seconds() / 60 / 60
        if offset_fl < 0:
            negative = True
            offset_fl *= -1
        else:
            negative = False

        formatted = str(datetime.timedelta(hours=offset_fl))
        formatted = formatted[:formatted.rfind(":")]

        if negative:
            formatted = "-{}".format(formatted)
        else:
            formatted = "+{}".format(formatted)
        return formatted

    @staticmethod
    def _get_gender_ratio(obj_list, house_list) -> tuple:
        """
        :param: obj_list: list of objects (dict)
        :param: house_list: list of houses (dict)
        :return: MasculineGenderRatio(%), FeminineGenderRatio(%)
        """
        masc_count = 0
        fem_count = 0

        for obj in (obj_list + house_list):
            if obj["gender"] == "Masculine":
                masc_count += 1
            elif obj["gender"] == "Feminine":
                fem_count += 1

        # print("Masc: " + str(masc_count))
        # print("Fem: " + str(fem_count))
        masc_ratio = (round(100 * masc_count / (masc_count + fem_count)))
        fem_ratio = (round(100 * fem_count / (masc_count + fem_count)))

        return masc_ratio, fem_ratio

    @staticmethod
    def _get_elements_ratio(obj_list, house_list) -> tuple:
        """
        :param obj_list: list of objects (dict)
        :param house_list: list of houses (dict)
        :return: FireSignRatio(%), WaterSignRatio(%), EarthSignRatio(%), AirSignRatio(%)
        """

        # TODO -> http://astrology.care/balance_elements.html

        return None

    @staticmethod
    def _get_modality_ratio(obj_list, house_list) -> tuple:
        """
        :param obj_list: list of objects (dict)
        :param house_list: list of houses (dict)
        :return: FixedModalityRatio(%), CardinalModalityRatio(%), MutableModalityRatio(%)
        """
        fixed_count = 0
        cardinal_count = 0
        mutable_count = 0

        for obj in (obj_list + house_list):
            if obj["sign"] in ac_const.FIXED_SIGNS:
                fixed_count += 1
            elif obj["sign"] in ac_const.CARDINAL_SIGNS:
                cardinal_count += 1
            elif obj["sign"] in ac_const.MUTABLE_SIGNS:
                mutable_count += 1

        fixed_ratio = (round(100 * fixed_count / (fixed_count + cardinal_count + mutable_count)))
        cardinal_ratio = (round(100 * cardinal_count / (fixed_count + cardinal_count + mutable_count)))
        mutable_ratio = (round(100 * mutable_count / (fixed_count + cardinal_count + mutable_count)))
        return fixed_ratio, cardinal_ratio, mutable_ratio

    def _define_objects(self) -> list[dict]:
        """
        Creates list of objects
        :return: List of natal chart objects in dicts
        """
        obj_list = []
        for obj in self.chart.objects:
            obj_dict = {
                "name": obj.id,
                "sign": obj.sign,
                "sign_angle": angle.toString(obj.signlon),
                "angle": angle.toString(obj.lonspeed),
                "longitude": obj.lon,
                "latitude": obj.lat,
                "gender": None,
                "house": None
            }
            for house in self.chart.houses:
                if house.hasObject(obj):
                    obj_dict["house"] = house.num()
                    break

            try:
                obj_dict["gender"] = obj.gender()
            except KeyError:
                pass

            # print(obj_dict["longitude"])
            obj_list.append(obj_dict)
        return obj_list

    def _define_houses(self) -> list[dict]:
        """
        Creates list of houses
        :return: List of natal chart houses in dicts
        """
        house_list = []
        for house in self.chart.houses:
            house_name = house.id
            if house_name == "House1":
                house_name += " (Ascendant)"
            elif house_name == "House10":
                house_name += " (MC)"

            house_dict = {
                "name": house_name,
                "sign": house.sign,
                "angle": angle.toString(house.lon),
                "gender": None
            }
            try:
                house_dict["gender"] = house.gender()
            except KeyError:
                pass
            house_list.append(house_dict)
        return house_list

    def create_chart(self):
        offset = self.find_offset(self.lat, self.lon)
        date = Datetime(self.date, self.time, offset)
        pos = GeoPos(self.lat, self.lon)

        self.chart = Chart(date, pos)
        self.objects = self._define_objects()
        self.houses = self._define_houses()
        self.gender_ratio = self._get_gender_ratio(self.objects, self.houses)
        self.modality_ratio = self._get_modality_ratio(self.objects, self.houses)
        self.elements_ratio = self._get_elements_ratio(self.objects, self.houses)
        return True


"""

print(chart.objects)
for angle in chart.angles:
    print(angle)


a = chart.objects
for b in a:
    print(b)
"""
