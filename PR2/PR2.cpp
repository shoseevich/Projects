#include <iostream>
#include <fstream>
#include <sstream>
#include <vector>
#include <map>
#include <string>
#include <algorithm>

using namespace std;

int main() {
    setlocale(LC_ALL, "Russian");

    ifstream document("document.txt");
    ifstream kit("kit.txt");

    if (!document.is_open() || !kit.is_open()) {
        cerr << "Error opening files!" << endl;
        return 1;
    }

    map<string, int> catalogUsage;
    map<string, int> catalogLimits;
    map<string, string> catalogEndPosition;
    string line;

    getline(kit, line); 
    while (getline(kit, line)) {
        stringstream ss(line);
        string catalog;
        int quantity;
        getline(ss, catalog, '\t');
        ss >> quantity;
        catalog.erase(remove(catalog.begin(), catalog.end(), '"'), catalog.end());
        catalogLimits[catalog] = quantity;
    }

    getline(document, line);

    vector<string> singleCategoryLines;
    vector<string> multipleCategoryLines;

    map<string, bool> catalogFound;
    for (const auto& entry : catalogLimits) {
        catalogFound[entry.first] = false;
    }


    while (getline(document, line)) {
        stringstream ss(line);
        string pos, quantity, catalogs;
        getline(ss, pos, '\t');
        getline(ss, quantity, '\t');
        getline(ss, catalogs, '\t');

        if (catalogs.empty()) continue;

        stringstream catalogsStream(catalogs);
        string catalog;
        while (getline(catalogsStream, catalog, ',')) {
            catalog.erase(remove(catalog.begin(), catalog.end(), '"'), catalog.end());
            catalog.erase(remove(catalog.begin(), catalog.end(), ' '), catalog.end());

            if (!catalog.empty() && catalogLimits.find(catalog) != catalogLimits.end()) {
                catalogFound[catalog] = true;
            }
        }

        if (count(catalogs.begin(), catalogs.end(), ',') == 0) {
            singleCategoryLines.push_back(line);
        }
        else {
            multipleCategoryLines.push_back(line);
        }
    }
    bool allCatalogsFound = true;
    for (const auto& entry : catalogFound) {
        if (!entry.second) {
            allCatalogsFound = false;
            break;
        }
    }

    if (allCatalogsFound) {
        cout << "Набор содержится в документе." << endl;
        cout << "Состав набора." << endl;
     

    for (const auto& singleLine : singleCategoryLines) {
        stringstream ss(singleLine);
        string pos, quantity, catalogs;
        getline(ss, pos, '\t');
        getline(ss, quantity, '\t');
        getline(ss, catalogs, '\t');

        stringstream catalogsStream(catalogs);
        string catalog;
        while (getline(catalogsStream, catalog, ',')) {
            catalog.erase(remove(catalog.begin(), catalog.end(), '"'), catalog.end());
            catalog.erase(remove(catalog.begin(), catalog.end(), ' '), catalog.end());

            if (!catalog.empty()) {
                int usage = stoi(quantity);
                while (usage > 0) {
                    if (catalogUsage[catalog] + usage > catalogLimits[catalog]) {
                        usage = catalogLimits[catalog] - catalogUsage[catalog];
                    }
                    catalogUsage[catalog] += usage;
                    if (catalogUsage[catalog] == catalogLimits[catalog] && catalogEndPosition.find(catalog) == catalogEndPosition.end()) {
                        catalogEndPosition[catalog] = pos;
                        break;
                    }
                    usage = stoi(quantity) - catalogUsage[catalog];
                }
            }
        }
    }

    for (const auto& multipleLine : multipleCategoryLines) {
        stringstream ss(multipleLine);
        string pos, quantity, catalogs;
        getline(ss, pos, '\t');
        getline(ss, quantity, '\t');
        getline(ss, catalogs, '\t');

        stringstream catalogsStream(catalogs);
        string catalog;
        while (getline(catalogsStream, catalog, ',')) {
            catalog.erase(remove(catalog.begin(), catalog.end(), '"'), catalog.end());
            catalog.erase(remove(catalog.begin(), catalog.end(), ' '), catalog.end());

            if (!catalog.empty()) {
                int usage = stoi(quantity);
                while (usage > 0) {
                    if (catalogUsage[catalog] + usage > catalogLimits[catalog]) {
                        usage = catalogLimits[catalog] - catalogUsage[catalog];
                    }
                    catalogUsage[catalog] += usage;
                    if (catalogUsage[catalog] == catalogLimits[catalog] && catalogEndPosition.find(catalog) == catalogEndPosition.end()) {
                        catalogEndPosition[catalog] = pos;
                        break;
                    }
                    usage = stoi(quantity) - catalogUsage[catalog];
                }
            }
        }
    }

    vector<pair<int, pair<int, string>>> outputData;
    for (const auto& entry : catalogUsage) {
        outputData.push_back({ stoi(catalogEndPosition[entry.first]), {entry.second, entry.first} });
    }

    sort(outputData.begin(), outputData.end());

    cout << "Поз.\tКол-во\tКаталог" << endl;
    for (const auto& entry : outputData) {
        cout << entry.first << "\t" << entry.second.first << "\t\"" << entry.second.second << "\"" << endl;
    }
    }
    else {
        cout << "Набор не содержится в документе." << endl;
    }

    document.close();
    kit.close();

    return 0;
}