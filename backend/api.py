import os

from webbrowser import get
import json
from fastapi import APIRouter, Request

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



@api_router.get("/satellites", tags=["App","Planets"])
def planets(limit:int = -1, satellite_id:int=-1):
    if satellite_id > -1:
        if limit > -1:

            return form_select_response(db.gather_data("astronet_satellites",limit,{"id":satellite_id}))
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
    elif satellite_id < -1:
        return{
                "loc": [
                "query",
                "planet_id"
                ],
                "request":"failed",
                "error_message":"Satellite ID must be set > -1",
                "type": "value_error.planet_id"
                }

    else:
        if limit > -1:
            return form_select_response(db.gather_data("astronet_satellites",limit))
        elif limit == -1:
            return form_select_response(db.gather_data("astronet_satellites"))
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

@api_router.get("/adduser/", tags=["App","Admin"])
def read_root(username:str, password:str, mail:str, request: Request):
    client_host = str(request.client.host)
    if client_host != "127.0.0.1":
        return {
                "loc": [
                "permissions"
                ],
                "request":"failed",
                "error_message":"Access denied",
                "type": "access.denied"
            }
    else:
        os.system("php forum/bin/phpbbcli.php -U {} -P {} -E {}".format(username, password, mail))
        return {"status": "ok",
                "user":{"username": username,
                       "password": password,
                       "e-mail": mail
                }
                }