<?php
 
namespace App\Services;
  
class DriverExpenseService
{
    public $addToSecondDriver;

    public $driverExpenses;

    public function calculateDriverExpenses(array $drivers, array $expenses)
    {

        foreach($drivers as $key => $driver){
            $this->driverExpenses[$key] = ['name' => $driver, 'expenses' => []];
        }
        
        $this->addToSecondDriver = false;
        foreach($expenses as $name => $price) {
            foreach($drivers as $key => $driver) {
                $centsAfterSplit = round($price/2 - floor($price/2), 3);
                $this->driverExpenses[$key]['expenses'][$name] = round($price/2, 2);
            }
            if ($this->countDecimals($centsAfterSplit) > 2) {
                if ($this->addToSecondDriver) {
                    $this->driverExpenses[0]['expenses'][$name] -= 0.01;
                } else {
                    $this->driverExpenses[1]['expenses'][$name] -= 0.01;
                }
                $this->addToSecondDriver = !$this->addToSecondDriver;
            }
        }
        
        $result = [
            'driverExpenses' => $this->driverExpenses,
            'expenses' => $expenses,
            'drivers' => $drivers,
            'totals' => $this->calculateTotals($expenses),
        ];

        return $result;

    }

    private function countDecimals($number) 
    {
        $count = 0;
        $decimal = strpos($number, ".");
        if ($decimal !== false) {
            $count = strlen($number) - $decimal - 1;
        }
        return $count;
    }

    private function calculateTotals($baseExpenses) 
    {
        $totalExpenses = [];
        $totalExpenses['Total'] = 0;
        foreach($baseExpenses as $baseExpense) {
            $totalExpenses['Total'] += $baseExpense;
        }

        foreach($this->driverExpenses as $driverExpense) {
            $totalExpenses[$driverExpense['name']] = 0;
            foreach($driverExpense['expenses'] as $expense) {
                $totalExpenses[$driverExpense['name']] += $expense;
            }
        }
    
        
        return $totalExpenses;
    }
}