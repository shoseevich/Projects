#ifndef TRANSPORTFACTORY_H
#define TRANSPORTFACTORY_H

#include "Transport.h"

class TransportFactory {
public:
    static Transport* createTransport(int type);
};

#endif