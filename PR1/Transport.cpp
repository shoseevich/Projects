#include "Transport.h"
#include <iostream>
using namespace std;

Transport::Transport(string name, int speed, int wheels) : name(name), speed(speed), wheels(wheels) {}

void Transport::displayParameters() const {
    cout << "Наименование транспорта: " << name << endl;
    cout << "Количество колёс: " << wheels << endl;
    cout << "Максимальная скорость: " << speed << "км/ч" << endl;
}

Scooter::Scooter(string name, int speed, int wheels, string typeOfPower)
    : Transport(name, speed, wheels), typeOfPower(typeOfPower) {}

void Scooter::displayParameters() const {
    Transport::displayParameters();
    cout << "Тип питания: " << typeOfPower << endl;
    cout << endl;
}

Bike::Bike(string name, int speed, int wheels) : Transport(name, speed, wheels) {}

void Bike::displayParameters() const {
    Transport::displayParameters();
    cout << endl;
}

Car::Car(string name, int speed, int wheels) : Transport(name, speed, wheels) {}

void Car::displayParameters() const {
    Transport::displayParameters();
    cout << endl;
}

Bus::Bus(string name, int speed, int wheels, int passengers)
    : Transport(name, speed, wheels), passengers(passengers) {}

void Bus::displayParameters() const {
    Transport::displayParameters();
    cout << "Количество пассажиров: " << passengers << endl;
    cout << endl;
}