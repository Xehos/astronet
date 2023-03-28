import os

from webbrowser import get
import json
from fastapi import APIRouter, Request

import astronet_backend

api_router = APIRouter()

db = astronet_backend.DBHandler(hostname=os.environ.get("MYSQL_HOSTNAME"),
        username=os.environ.get("MYSQL_USER"),password=os.environ.get("MYSQL_PASSWORD"),
        db=os.environ.get("MYSQL_DB"))

def form_select_response(data) -> dict:
    return {"request":"ok","objects":data}

def no_api_key_access() -> str:
    return "None, wrong or revoked API key has been provided, or daily quota reached!"

def check_api_key(api_key) -> bool:
    api_key_list = db.gather_data("astronet_api_keys",1,{"api_key":api_key})
    print(api_key_list)
    if len(api_key_list)>0:
        api_key = api_key_list[0]
        if api_key["requests_today"] < api_key["requests_quota"] and api_key["revoked"] == 0:
            db.add_number("astronet_api_keys",
                {
                "number_col":"requests_today",
                "number":1,
                "selector_col":"api_key",
                "selector":api_key["api_key"]
                }

                )
            return True
    return False 



# FastAPI: Index
@api_router.get("/", tags=["App"])
def info():
    return {
        "app_name": "AstroNet API",
        "app_description": "Oficiální API pro projekt AstroNet",
        "app_version": "1.0",
    }


@api_router.get("/ssplanets", tags=["App","Objects","Planets"])
def planets(api_key:str = "",limit:int = -1,planet:str = "", planet_id:int=-1):
    if api_key == "" or not check_api_key(api_key):
        return no_api_key_access()
    

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



@api_router.get("/satellites", tags=["App","Objects","Satellites"])
def satellites(api_key:str = "",limit:int = -1, satellite_id:int=-1):
    if api_key == "" or not check_api_key(api_key):
        return no_api_key_access()
    

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

@api_router.get("/addforumuser/", tags=["App","Admin"])
def add_user(username:str, password:str, mail:str, request: Request):

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
        os.system("php forum/bin/phpbbcli.php user:add -U {} -P {} -E {}".format(username, password, mail))
        return {"status": "ok",
                "user":{"username": username,
                       "password": password,
                       "e-mail": mail
                }
                }

@api_router.get("/delforumuser/", tags=["App","Admin"])
def add_user(username:str, password:str, mail:str, request: Request):

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
        os.system("php forum/bin/phpbbcli.php user:delete -n {}".format(username))
        return {"status": "ok",
                "deleted_user":{"username": username,    
                }
                }