import os

from webbrowser import get
import json
from fastapi import APIRouter

import astronet_backend

api_router = APIRouter()

db = astronet_backend.DBHandler(hostname=os.environ.get("MYSQL_HOSTNAME"),
        username=os.environ.get("MYSQL_USER"),password=os.environ.get("MYSQL_PASSWORD"),
        db=os.environ.get("MYSQL_DB"))

def form_select_response(data):
    return {"request":"ok","objects":data}

# FastAPI: Index
@api_router.get("/", tags=["App"])
def info():
    return {
        "app_name": "AstroNet API",
        "app_description": "Oficiální API pro projekt AstroNet",
        "app_version": "1.0",
    }


@api_router.get("/ssplanets", tags=["App","Planets"])
def planets(limit:int = -1,planet:str = "", planet_id:int=-1):
    if planet!="":
        if limit > -1:
            return form_select_response(db.gather_data("astronet_ssplanets",limit,{"name":planet}))
        else:
            return{
                "loc": [
                "query",
                "limit"
                ],
                "request":"failed",
                "error_message":"Limit must be set > -1",
                "type": "value_error.limit"
            }
    elif planet_id > -1:
        if limit > -1:
            return form_select_response(db.gather_data("astronet_ssplanets",limit,{"id":planet_id}))
        else:
            return{
                "loc": [
                "query",
                "limit"
                ],
                "request":"failed",
                "error_message":"Limit must be set > -1",
                "type": "value_error.limit"
                }
    elif planet_id < -1:
        return{
                "loc": [
                "query",
                "planet_id"
                ],
                "request":"failed",
                "error_message":"Planet ID must be set > -1",
                "type": "value_error.planet_id"
                }

    else:
        if limit > -1:
            return form_select_response(db.gather_data("astronet_ssplanets",limit))
        elif limit == -1:
            return form_select_response(db.gather_data("astronet_ssplanets"))
        else:
            return{
                "loc": [
                "query",
                "limit"
                ],
                "request":"failed",
                "error_message":"Limit must be set > -1",
                "type": "value_error.limit"
            }



    