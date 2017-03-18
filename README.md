# smart-php
Small php framework, fast, simple and powerful

### TODO
- Database:
    - Query builder
        - dynamique:
            - insert dynamique
            - update dynamique
            - delete dynamique
        - find:
            - by(array $where_list)
- Controller:
    - redirect()
    - generateUrl()
    - isGranted()
- Systeme de message flash
- Twig addons:
    - Function:
        - path($route_name, array $params): Retourne une url
        - isGranted($role): retourne si l'utilisateur courant à le role $role
        - form($form): retourne le formulaire entier
    - Global:
        - app.user: retourne l'utilisateur courant