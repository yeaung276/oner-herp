from datetime import datetime, timedelta

def inventoryFilterForExpiry(llimit:int,ulimit:int):
    return lambda x: x.expiry_date != None and \
        x.balance > 0 and\
        timedelta(days=llimit*30) < (x.expiry_date - datetime.now().date()) < timedelta(days=ulimit*30)