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
- Gestion des erreurs:
    - Erreur 404 Router() Ligne 54
    - Erreur Method (Get, Post) Router() Ligne 50
    - Erreur Class not found Kernel() Ligne 46
    - Affichage des erreurs listé au dessus Kernel() Ligne 58
- Twig addons:
    - Function:
        - path($route_name, array $params): Retourne une url
        - [OK] asset($file_path): Retourne un chemin de fichier
        - isGranted($role): retourne si l'utilisateur courant à le role $role
        - form($form): retourne le formulaire entier
    - Global:
        - app.user: retourne l'utilisateur courant
        - [OK] debug: retourne un boolean si l'environement est en debug ou non