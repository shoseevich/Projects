// PR1.cpp: определяет точку входа для приложения.
//

#include "TransportFactory.h"
#include <iostream>
#include <cstdlib>

int main(int argc, char* argv[]) {
    setlocale(LC_ALL, "Russian");
    if (argc < 2) {
        std::cout << "Недостаточно аргументов!" << std::endl;
        return 1;
    }

    for (int i = 1; i < argc; i++) {
        int choice = std::atoi(argv[i]);
        Transport* transport = TransportFactory::createTransport(choice);
        if (transport) {
            transport->displayParameters();
            delete transport;
        }
    }

    return 0;
}
