from astralcompass.main import AstralCompass

if __name__ == "__main__":
    ac = AstralCompass(
        latitude=49.9638200,
        longitude=14.0720000,
        date='2004/04/22',
        time='16:30'
    )

    for house in ac.objects:
        print(house)
    print(ac.gender_ratio)
    print(ac.elements_ratio)

