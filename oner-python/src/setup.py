import os
from dotenv import load_dotenv
from functools import lru_cache

@lru_cache()
def cache_dotenv():
    load_dotenv()

cache_dotenv()
if os.environ.get('ENVIRONMENT')=='PRODUCTION' or os.environ.get('ENVIRONMENT')=='DEVELOPMENT':
    ROOT_PATH = os.environ.get('ROOT_PATH')
    SENTRY_DNS = os.environ.get('SENTRY_DNS')
else:
    ROOT_PATH = ''
    SENTRY_DNS = None

SQLALCHEMY_DATABASE_URL = os.environ.get('SQLALCHEMY_DATABASE_URL')
SECRET_KEY = os.environ.get('JWT_SECRET_KEY')
ALGORITHM = os.environ.get('JWT_ALGORITHM')
JWT_EXPIRY_MINUTE = os.environ.get('JWT_EXPIRY_MINUTE')
PORT = int(os.environ.get('PORT'))
ENVIRONMENT = os.environ.get('ENVIRONMENT')
