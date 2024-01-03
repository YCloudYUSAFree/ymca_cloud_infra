import yaml
import json


permissions_to_delete = []
with open('permissions.json') as f:
    permissions_to_delete = json.load(f)

file = open('config/optional/user.role.contributor.yml').readlines()
data = yaml.load(open('config/optional/user.role.contributor.yml'), Loader=yaml.FullLoader)

to_delete = []
for permission in permissions_to_delete:
    if permission in data['permissions']:
        data['permissions'].remove(permission)
        to_delete.append(permission)

print('Permissions to delete user.role.contributor.yml:')
print(json.dumps(to_delete, indent=4))
    
with open('config/optional/user.role.contributor.yml', 'w') as f:
    yaml.dump(data, f)

data = yaml.load(open('config/optional/user.role.site_owner.yml'), Loader=yaml.FullLoader)

to_delete = []
for permission in permissions_to_delete:
    if permission in data['permissions']:
        data['permissions'].remove(permission)
        to_delete.append(permission)

print('Permissions to delete user.role.site_owner.yml:')
print(json.dumps(to_delete, indent=4))

with open('config/optional/user.role.site_owner.yml', 'w') as f:
    yaml.dump(data, f)
