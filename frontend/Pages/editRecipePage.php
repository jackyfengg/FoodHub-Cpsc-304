<?php
require_once __DIR__ . '/../../backend/scripts/databaseconnection.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Registration - FoodHub</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.7.3/dist/full.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-base-content p-2.5 flex items-center justify-center h-full">
    <div class="card w-96 bg-neutral text-neutral-content ">
        <div class="card-body items-center text-center">
            <h2 class="card-title text-white mb-4">Edit Recipe</h2>
            <form action="/../../backend/src/queries/updateRecipe.php" method="post">
                <?php
                $editRecipeTitle = $_POST['edit-recipe-title'];
                $recipeDetailsQuery = $connection->prepare("SELECT * 
                FROM RecipeDetails WHERE Title = :editRecipeTitle");
                $recipeDetailsQuery->bindParam(':editRecipeTitle', $editRecipeTitle);
                $recipeDetailsQuery->execute();

                $recipe = $recipeDetailsQuery->fetchAll(PDO::FETCH_ASSOC);
                $firstRecipe = $recipe[0];
                $recipeTitle = $firstRecipe['title'];
                $recipeDescription = $firstRecipe['description'];
                $recipeCulture = $firstRecipe['culture'];
                $recipeDifficulty = $firstRecipe['difficulty'];
                $recipeServing = $firstRecipe['serving'];
                global $editRecipePublishDate;
                $editRecipePublishDate = $firstRecipe['publishdate'];

                $recipeQuery = $connection->prepare("SELECT * 
                FROM Recipe WHERE Title = :editRecipeTitle");
                $recipeQuery->bindParam(':editRecipeTitle', $editRecipeTitle);
                $recipeQuery->execute();

                $recipe = $recipeQuery->fetchAll(PDO::FETCH_ASSOC);
                $firstRecipe = $recipe[0];
                $recipeEstimatedTime = $firstRecipe['estimatedtime'];

                ?>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text text-white">Recipe description</span>
                    </label>
                    <textarea required name="edit-recipe-description"
                        class="input input-bordered text-zinc-950 h-32 resize-none"><?= htmlspecialchars($recipeDescription) ?></textarea>
                </div>

                <div class="form-control">
                    <label class="label" for="difficulty-level">
                        <span class="label-text text-white">Choose a difficulty level</span>
                    </label>
                    <select required class="input input-bordered text-zinc-950" name="edit-difficulty-level"
                        id="difficulty-level">
                        <option value="expert" <?php if ($recipeDifficulty === 'Expert')
                            echo 'selected'; ?>>Expert
                        </option>
                        <option value="difficult" <?php if ($recipeDifficulty === 'Difficult')
                            echo 'selected'; ?>>
                            Difficult</option>
                        <option value="intermediate" <?php if ($recipeDifficulty === 'Intermediate')
                            echo 'selected'; ?>>
                            Intermediate</option>
                        <option value="easy" <?php if ($recipeDifficulty === 'Beginner')
                            echo 'selected'; ?>>Beginner
                        </option>
                    </select>
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text text-white">Culture</span>
                    </label>
                    <input required name="edit-recipe-culture" type="text"
                        value="<?= htmlspecialchars($recipeCulture) ?>" class="input input-bordered text-zinc-950">
                </div>

                <div class="form-control">
                    <label class="label" for="rating-level">
                        <span class="label-text text-white">Choose a rating level</span>
                    </label>
                    <select required class="input input-bordered text-zinc-950" name="edit-rating-level"
                        id="rating-level">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text text-white">Servings</span>
                    </label>
                    <input name="edit-recipe-servings" required type="number"
                        value="<?= htmlspecialchars($recipeServing) ?>" class="input input-bordered text-zinc-950">
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text text-white">Estimated Time</span>
                    </label>
                    <input name="edit-estimated-time" required type="number"
                        value="<?= htmlspecialchars($recipeEstimatedTime) ?>"
                        class="text-zinc-950 input input-bordered">
                </div>
                <?
                error_reporting(E_ALL);
                ini_set('display_errors', 1);
                ?>
                <div class="form-control mt-6">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>