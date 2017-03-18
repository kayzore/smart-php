# smart-php
Small php framework, fast, simple and powerful

### TODO
- Database:
     Système de connexion avec la possibilité de se connecter a plusieurs bdd de type différent
    - Query builder
        - insert()
        - update()
        - delete()
        - find:
            - byId($id)
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