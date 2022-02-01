import setup
import os
from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
import uvicorn
from app.controllers import router
import sentry_sdk
from sentry_sdk.integrations.asgi import SentryAsgiMiddleware
from fastapi_pagination import add_pagination

# configure app
app = FastAPI(
    root_path=setup.ROOT_PATH
)
app.include_router(router)

# crash reporting system
sentry_sdk.init(
   setup.SENTRY_DNS,
   environment=setup.ENVIRONMENT
)
app.add_middleware(SentryAsgiMiddleware)

# cros enable
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)


# test route
@app.get('/')
def index():
    return 'Welcome from Oner Hospital Management Software.' 

add_pagination(app)

# run app
if __name__=='__main__':
    uvicorn.run('main:app', host='0.0.0.0', port=setup.PORT, reload=True, log_level='debug')