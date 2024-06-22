import os
from dotenv import load_dotenv
import astronet_backend

import uvicorn
from fastapi import FastAPI

from api import api_router



# FastAPI: Config
api = FastAPI(
    title="AstroNet API",
    description="Oficiální API pro projekt AstroNet",
    version="1.0",
)

api.include_router(api_router)

load_dotenv()

if __name__ == '__main__':
	

	#print(db.gather_data("astronet_ssplanets",10))
	uvicorn.run(
        "main:api",
        host="0.0.0.0",
        port=4001,
        log_level="debug",
        reload=True

    )