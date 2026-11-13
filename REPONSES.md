# TP2 — Symfony : Formulaires, Validation, Relations et CRUD

## Partie 1 — Formulaires Symfony

### Question 1 : Quel est l'intérêt de créer une classe FormType plutôt que de construire le formulaire directement dans le contrôleur ?

La classe FormType permet de séparer la construction du formulaire de la logique du contrôleur.

Elle présente plusieurs avantages :
- Le code est mieux organisé et plus lisible.
- Le formulaire peut être réutilisé dans plusieurs contrôleurs.
- La maintenance et les modifications sont plus faciles.
- Le contrôleur reste consacré au traitement des requêtes et à la logique métier.

### Question 2 : Quelles sont les étapes du traitement d'un formulaire Symfony ?

Le traitement d'un formulaire Symfony suit plusieurs étapes :

1. Créer une instance de l'entité.
2. Construire le formulaire avec `createForm()`.
3. Traiter la requête avec `handleRequest()`.
4. Vérifier si le formulaire a été soumis avec `isSubmitted()`.
5. Vérifier sa validité avec `isValid()`.
6. Enregistrer les données avec Doctrine (`persist()` et `flush()`).
7. Rediriger l'utilisateur vers une autre page.

### Question 3 : Quelle est la différence entre form_row(), form_label() et form_widget() ?

- `form_row()` affiche le champ complet : label, widget et erreurs de validation.
- `form_label()` affiche uniquement le label du champ.
- `form_widget()` affiche uniquement le champ de saisie.

`form_row()` est pratique pour afficher rapidement un formulaire, tandis que `form_label()` et `form_widget()` permettent de personnaliser davantage sa présentation.

## Partie 2 — Validation des données

### Question 4 : Quelle est la différence entre la validation côté client et la validation côté serveur ?

La validation côté client est effectuée dans le navigateur, généralement avec HTML5 ou JavaScript. Elle permet de signaler rapidement les erreurs à l'utilisateur.

La validation côté serveur est effectuée par Symfony après l'envoi du formulaire.

La validation côté serveur est indispensable pour la sécurité et la fiabilité des données, car les contrôles côté client peuvent être contournés.

## Partie 3 — Relations Doctrine

### Question 5 : Que fait la migration générée après l'ajout de la relation ManyToOne entre Article et Categorie ?

La migration modifie la structure de la base de données en ajoutant une colonne `categorie_id` dans la table `article`.

Cette colonne est une clé étrangère qui référence l'identifiant `id` de la table `categorie`.

Elle permet d'associer chaque article à une catégorie et garantit l'intégrité référentielle entre les deux tables.

### Question 6 : Quelle est la différence entre createFormBuilder() et une classe FormType ?

`createFormBuilder()` permet de construire rapidement un formulaire directement dans le contrôleur. Il est adapté aux formulaires simples et ponctuels.

Une classe FormType sépare la définition du formulaire du contrôleur. Elle est plus adaptée aux formulaires réutilisables et aux projets nécessitant une meilleure organisation du code.

## Partie 4 — Modification et suppression

### Question 7 : Pourquoi ne faut-il pas appeler persist() lors de la modification d'une entité existante ? Quel concept Doctrine explique ce comportement ?

Lorsqu'une entité existante est récupérée depuis la base de données avec Doctrine, elle est déjà suivie par l'EntityManager.

Elle est considérée comme une entité *managed* (gérée).

Doctrine surveille automatiquement ses modifications. Il suffit donc d'appeler `flush()` pour enregistrer les changements dans la base de données.

La méthode `persist()` est principalement utilisée pour enregistrer une nouvelle entité.

### Question 8 : Qu'est-ce qu'une attaque CSRF ? Pourquoi est-il dangereux d'utiliser une simple requête GET pour supprimer une ressource ?

Une attaque CSRF (Cross-Site Request Forgery) consiste à faire exécuter à un utilisateur authentifié une action sur un site sans qu'il en ait réellement donné l'autorisation.

Un token CSRF permet de vérifier que la requête provient bien d'un formulaire légitime de l'application.

Il est dangereux d'utiliser une requête GET pour supprimer une ressource, car une simple visite d'un lien pourrait déclencher une suppression involontaire.

Il est donc préférable d'utiliser une requête POST accompagnée d'un token CSRF.

## Conclusion

Ce TP m'a permis de découvrir et de mettre en pratique plusieurs fonctionnalités de Symfony :

- Création et traitement des formulaires avec FormType.
- Validation des données avec les contraintes Symfony.
- Gestion des relations entre entités avec Doctrine.
- Réalisation d'un CRUD complet pour les articles et les catégories.
- Protection des opérations sensibles avec les tokens CSRF.
- Utilisation de Git et GitHub pour gérer les branches et les Pull Requests.