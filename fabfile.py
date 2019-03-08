from tools.fablib import *

from fabric.api import task

"""
Getting set up for the first time and using vim?
Run:
    :%s/currentorg/project_name/g       # name for the project, used as the database name. This should match the umbrella repository name and the domain.wpengine.com name
    :%s/CURRENTORG/YOUR_SITE_ENV_VAR/g      # environment variable slug from INN's secrets repository
"""

"""
Base configuration
"""
env.project_name = 'currentorg'
env.hosts = ['localhost', ]
env.sftp_deploy = True # needed for wpengine
env.domain = 'currentorg.dev'

"""
Add HipChat info to send a message to a room when new code has been deployed.
"""
env.hipchat_token = ''
env.hipchat_room_id = ''


# Environments
@task
def production():
    """
    Work on production environment
    """
    env.settings    = 'production'
    env.hosts       = [ os.environ[ 'CURRENTORG_PRODUCTION_SFTP_HOST' ], ]   # ssh host for production.
    env.user        = os.environ[ 'FLYWHEEL_SFTP_USER' ]        # ssh user for production.
    env.password    = os.environ[ 'FLYWHEEL_SFTP_PASS' ]    # ssh password for production.
    env.path        = os.environ[ 'CURRENTORG_PRODUCTION_SFTP_PATH' ]        # sftp path
    env.domain      = 'currentorg.wpengine.com'
    env.port        = '22'


@task
def staging():
    """
    Work on staging environment
    """
    env.settings    = 'staging'
    env.hosts       = [ os.environ[ 'CURRENTORG_STAGING_SFTP_HOST' ], ]   # ssh host for production.
    env.user        = os.environ[ 'FLYWHEEL_SFTP_USER' ]        # ssh user for production.
    env.password    = os.environ[ 'FLYWHEEL_SFTP_PASS' ]    # ssh password for production.
    env.path        = os.environ[ 'CURRENTORG_STAGING_SFTP_PATH' ]        # sftp path
    env.domain      = 'currentorg.staging.wpengine.com'
    env.port        = '22'

try:
    from local_fabfile import  *
except ImportError:
    pass
