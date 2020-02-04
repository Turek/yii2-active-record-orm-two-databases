<?php

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use app\models\Source;

/**
 * This command echoes the first argument that you have entered.
 */
class AppController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * 
     * @param int $count How many rows to create.
     * @return int Exit code.
     */
    public function actionGenerate($count = 10)
    {
        // Get count argument.
        $count = (int) $count;
        $dbCount = Source::find()->count();

        echo "There are " . $dbCount . " entries in the database.\n";
        echo "Generating " . $count . " random entries to Source database... ";

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
                    $source->data = $row['data'];
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
     * This command generates random row using Faker.
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
            'data' => $faker->randomFloat(NULL,200,99999999),
            'data2' => $faker->randomFloat(2,200,99999999),
        ];
    }
}
