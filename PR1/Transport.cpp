#include "Transport.h"
#include <iostream>
using namespace std;

Transport::Transport(string name, int speed, int wheels) : name(name), speed(speed), wheels(wheels) {}

void Transport::displayParameters() const {
    cout << "������������ ����������: " << name << endl;
    cout << "���������� ����: " << wheels << endl;
    cout << "������������ ��������: " << speed << "��/�" << endl;
}

Scooter::Scooter(string name, int speed, int wheels, string typeOfPower)
    : Transport(name, speed, wheels), typeOfPower(typeOfPower) {}

void Scooter::displayParameters() const {
    Transport::displayParameters();
    cout << "��� �������: " << typeOfPower << endl;
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
    cout << "���������� ����������: " << passengers << endl;
    cout << endl;
}