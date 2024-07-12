#include "TransportFactory.h"
#include "Transport.h"
#include <iostream>

Transport* TransportFactory::createTransport(int type) {
    switch (type) {
    case 0:
        return new Bike();
    case 1:
        return new Scooter();
    case 2:
        return new Car();
    case 3:
        return new Bus();
    default:
        std::cout << "ÍÅÈÇÂÅÑÒÍÛÉ ÒÈÏ ÒÐÀÍÑÏÎÐÒÀ" << std::endl;
        return nullptr;
    }
}