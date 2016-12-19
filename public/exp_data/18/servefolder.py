import os.path
from flask import Flask, render_template

import sys

application = Flask(__name__)

debug = True


@application.route('/')
def index():
    pass

if __name__ == '__main__':
    application.debug = debug
    #application.config["ASSETS_DEBUG"] = debug
    application.run()
