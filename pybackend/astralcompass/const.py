"""
Modality
"""

CARDINAL_SIGNS = ["Aries", "Cancer", "Libra", "Capricorn"]
FIXED_SIGNS = ["Taurus", "Leo", "Scorpio", "Aquarius"]
MUTABLE_SIGNS = ["Gemini", "Virgo", "Sagittarius", "Pisces"]

"""
Elements
"""
FIRE_SIGNS = ["Aries", "Leo", "Sagittarius"]
WATER_SIGNS = ["Cancer", "Scorpio", "Pisces"]
EARTH_SIGNS = ["Taurus", "Virgo", "Capricorn"]
AIR_SIGNS = ["Gemini", "Libra", "Aquarius"]

"""
Dispositors

Sign :ruled by: Planet
"""

DISPOSITORS = {
    "Aries": "Mars",
    "Taurus": "Venus",
    "Gemini": "Mercury",
    "Cancer": "Moon",
    "Leo": "Sun",
    "Virgo": "Mercury",
    "Libra": "Venus",
    "Scorpio": "Mars",  # + Pluto
    "Sagittarius": "Jupiter",
    "Capricorn": "Saturn",
    "Aquarius": "Saturn",  # + Uranus
    "Pisces": "Jupiter"  # + Neptune
}
