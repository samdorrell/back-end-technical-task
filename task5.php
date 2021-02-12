<?php
/**
 * Summary of Refactorisations:
 * 1. Created a 'getRentalCost' public method and 'getOverdueDays' private method and moved from the 'Customer' class to the 'Rental' Class
 * 2. Replaced conditional statements for pricing with lookup arrays, this simplifies the logic and more effectively shows the business logic behind it (i.e. fixed costs and overdue costs)
 * 3. removed $total and $frequentRenterPoints from Customer.getStatement() as they weren't being used in the output. I've simpliofied and moved the frequentRenterPoints logic to Rental Object - not sure if that will be needed in the future.
 * 4. Replaced foreach with array_reduce in getStatement(). More declarative and easy to read.
 */
class Film
{
    public function __construct($title, $priceCode)
    {
        $this->_title = $title;
        $this->_priceCode = $priceCode;
    }
    public function getPriceCode()
    {
        return $this->_priceCode;
    }
    public function setPriceCode($value)
    {
        $this->_priceCode = $value;
    }
    public function getTitle()
    {
        return $this->_title;
    }
    private $_title;
    private $_priceCode;
    const CHILDRENS = 2;
    const REGULAR = 0;
    const NEW_RELEASE = 1;
}
class Rental
{
    public function __construct($film, $daysRented)
    {
        $this->_film = $film;
        $this->_daysRented = $daysRented;
    }
    private function getOverdueDays()
    {
        $rentalPeriod = array(
            Film::REGULAR => 2,
            Film::NEW_RELEASE => 1,
            Film::CHILDRENS => 3,
        );
        $priceCode = $this->_film->getPriceCode();
        $overdueDays = max( $this->_daysRented - $rentalPeriod[$priceCode] , 0);
        return $overdueDays;
    }
    public function getRentalCost()
    {        
        $fixedCost = array(
            Film::REGULAR => 2,
            Film::NEW_RELEASE => 3,
            Film::CHILDRENS => 1.5,
        );
        $overdueCost = array(
            Film::REGULAR => 1.5,
            Film::NEW_RELEASE => 3,
            Film::CHILDRENS => 1.5,
        );

        $priceCode = $this->_film->getPriceCode();
        $overdueDays = $this->getOverdueDays();
        $rentalCost = $fixedCost[$priceCode] + $overdueDays * $overdueCost[$priceCode];

        return $rentalCost;
    }
    public function getFrequentRenterPoints()
    {
        $priceCode = $this->_film->getPriceCode();
        $overdueDays = $this->getOverdueDays();

        $frequentRenterPoints = 1;

        if ($priceCode == Film::NEW_RELEASE && $overdueDays > 0) {
            $frequentRenterPoints += 1;
        } 
        
        return $frequentRenterPoints;
    }
    /**
     * @return Film
     */
    public function getFilm()
    {
        return $this->_film;
    }
    private $_film;
    private $_daysRented;
}
class Customer
{
    public function __construct($name)
    {
        $this->_name = $name;
        $this->_rentals = array();
    }
    public function addRental($rental)
    {
        array_push($this->_rentals, $rental);
    }
    public function getName()
    {
        return $this->_name;
    }
    public function getStatement()
    {
        $heading = "Rental Record for " . $this->getName() . "\n";

        $rentalHistory = array_reduce($this->_rentals, function( $result, $rental ){            
            $title = $rental->getFilm()->getTitle();
            $rentalCost = $rental->getRentalCost();

            return $result .= "\t" . $title . "\t" . $rentalCost . "\n";
        });

        return $heading . $rentalHistory;
    }
    private $_name;
    private $_rentals;
}

$film1 = new Film('Ace ventura',Film::CHILDRENS);
$film2 = new Film('The exorcist',Film::REGULAR);
$film3 = new Film('No time to die',Film::NEW_RELEASE);
$rental1 = new Rental($film1,5);
$rental2 = new Rental($film2,4);
$rental3 = new Rental($film3,3);
$customer1 = new Customer('Sam');
$customer1->addRental($rental1);
$customer1->addRental($rental2);
$customer1->addRental($rental3);
echo $customer1->getStatement();