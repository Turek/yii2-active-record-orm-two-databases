<?php

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use app\models\Source;
use app\models\Destination;

/**
 * This class contains two CLI commands needed for this project.
 */
class AppController extends Controller
{
    /**
     * Generates specified number of random rows to Source database.
     * 
     * @param int $count How many rows to create.
     * @return int Exit code.
     */
    public function actionGenerateRows($count = 10)
    {
        // Get count argument.
        $count = (int) $count;
        $dbCount = Source::find()->count();

        echo "There are " . $dbCount . " entries in the database.\n";
        echo "Generating " . $count . " random entries to Source database... ";

        // Use transactions for more performance when saving multiple rows.
        $transaction = Source::getDb()->beginTransaction();
        try
        {
            if ($count > 0)
            {
                for ($i = 0; $i < $count; $i++)
                {
                    $row = $this->generateFakeRow();
                    $source = new Source();
                    $source->name = $row['name'];
                    $source->surname = $row['surname'];
                    $source->email = $row['email'];
                    $source->data = floatval($row['data']);
                    $source->data2 = $row['data2'];
                    $source->save();
                }
                $transaction->commit();
            }
        }
        catch(\Exception $e)
        {
            $transaction->rollBack();
            throw $e;
        }
        catch(\Throwable $e)
        {
            $transaction->rollBack();
            throw $e;
        }

        echo "Done.\n";

        return ExitCode::OK;
    }

    /**
     * Generates a random row using Faker.
     *
     * @return array Row of data.
     */
    private function generateFakeRow()
    {
        $faker = \Faker\Factory::create();
        return [
            'name' => $faker->firstName(),
            'surname' => $faker->lastName,
            'email' => $faker->email,
            'data' => $faker->randomFloat(2,200,99999999),
            'data2' => $faker->randomFloat(2,200,99999999),
        ];
    }

    /**
     * Moves data from Source database table to Destination database.
     * 
     * @return int Exit code.
     */
    public function actionMoveData()
    {
        $records = Source::find()->all();
        $recordsCount = count($records);
        $recordsSaved = 0;
        $formatter = \Yii::$app->formatter;

        // Loop through all records.
        if ($recordsCount)
        {
            // Use transactions for more performance when saving multiple rows.
            $transaction = Source::getDb()->beginTransaction();
            try
            {
                foreach ($records as $i => $row)
                {
                    $fullname = $row->name . ' ' . $row->surname;
                    // Basic check if entity already exists.
                    $product = Destination::find()->where([
                        'fullname' => $fullname,
                        'e_mail' => $row->email,
                    ])->all();
                    // Create record if none was found.
                    if (empty($product)) 
                    {
                        $destination = new Destination();
                        $destination->fullname = $fullname;
                        $destination->e_mail = $row->email;
                        $destination->balance = $row->data;
                        $destination->totalpurchase = $row->data2;
                        $destination->save();
                        $recordsSaved++;
                    }
                }
                unset($destination);
            }
            catch(\Exception $e)
            {
                $transaction->rollBack();
                throw $e;
            }
            catch(\Throwable $e)
            {
                $transaction->rollBack();
                throw $e;
            }
        }

        echo $recordsSaved . "/" . $recordsCount . " records moved to Destination database.\n";

        return ExitCode::OK;
    }

}
