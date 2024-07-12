#ifndef TRANSPORT_H
#define TRANSPORT_H

#include <string>

class Transport {
private:
    std::string name;
    int speed;
    int wheels;

public:
    Transport(std::string name, int speed, int wheels);
    virtual void displayParameters() const;
    virtual ~Transport() = default;
};

class Scooter : public Transport {
private:
    std::string typeOfPower;
public:
    Scooter(std::string name = "Самокат", int speed = 60, int wheels = 2, std::string typeOfPower = "Электрический");
    void displayParameters() const override;
};

class Bike : public Transport {
public:
    Bike(std::string name = "Мотоцикл", int speed = 120, int wheels = 2);
    void displayParameters() const override;
};

class Car : public Transport {
public:
    Car(std::string name = "Автомобиль", int speed = 150, int wheels = 4);
    void displayParameters() const override;
};

class Bus : public Transport {
private:
    int passengers;
public:
    Bus(std::string name = "Автобус", int speed = 100, int wheels = 6, int passengers = 20);
    void displayParameters() const override;
};

#endif // TRANSPORT_H