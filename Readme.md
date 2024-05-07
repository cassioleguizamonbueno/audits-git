### Como realizar o teste

1. Efetue o fork deste repositório e crie um branch com o seu nome. (ex: ronaldo-rodrigues).
2. Após finalizar o desafio, crie um Pull Request com o seu nome. (ex: ronaldo-rodrigues).
3. Envie um e-mail para team@properfy.com.br com o link do seu repositorio público.

### Teste de contratação

O ojetivo deste teste é avaliar a sua capacidade técnica em boas 
práticas de programação, qualidade de código, organização e algoritimo.

### Descrição do teste

Transformar dados vindos de coleção de arquivos .json para diversos formatos de XML, 
para publicação em portais diversos de imóveis.

O teste roda pelo comando
```shell
php index.php
```

### Observações
* Os tipos de imóvel possíveis estão listados em ./database/types.json.
* Após resolver o problema destes dois formatos de XML, muitos outros formatos de XML podem ser solicitados, 
por isso, a solução deve ser escalável e de fácil manutenção.
* A solução deve ser feita dentro do namespace PlatformXMLBuilder.
* Os XML devem ser salvos na pasta ./cache/{$portal}.xml onde cada portal precisa de um unico XML com todos os imóveis.
* Outras bibliotecas externas só devem ser usadas para trazer benefícios claros ao projeto.

### Sugestão
* Utilizar a biblioteca spatie/array-to-xml
* Utilizar uma array string=>string para identificar os portais e classes onde o campo "publishFor" vai listar onde o imóvel deve ser publicado.
```php
<?php
return [
    'estatify' => EstatifyXMLBuilder::class,
    'rentify' => RentifyXMLBuilder::class,
];
```

* A hierarquia de pastas de arquivos pode ser a seguinte:
```shell
PlatformXMLBuilder
    - Platforms
        - Contracts
            - XMLBuilderInterface.php
        - Helpers
        - Estatify
            - EstatifyXMLBuilder.php
...
```

### Exemplo

Dado os seguintes arquivos json:

```shell
> database/properties/
```

### SAIDA NO FORMATO PARA O Portal Estatify
```XML
<?xml version="1.0" encoding="UTF-8"?>
<collection>
    <property>
        <created>2021-01-01</created>
        <realState>
            <phone>11 99999-9999</phone>
            <email>email@realstate.com</email>
        </realState>
        <property>
            <year>2020</year>
            <ref>ABC00011</ref>
            <!-- Pode ser ['HOUSE', 'APARTMENT', 'STORE', 'PENTHOUSE'] -->
            <type>HOUSE</type>
            <forSale>sim</forSale>
            <forRent>não</forRent>
            <price>
                <sales>300,000.99</sales>
                <rent>0</rent>
            </price>
        </property>
        <address>
            <street>Rua 1</street>
            <number>99</number>
            <complement>Casa 10</complement>
            <district>Bairro 1</district>
            <city>Cidade 1</city>
            <state>Estado 1</state>
            <country>Brasil</country>
            <zipCode>00000000</zipCode>
        </address>
    </property>
</collection>
```

### SAIDA NO FORMATO PARA O Portal Rentify
```XML
<?xml version="1.0" encoding="UTF-8"?>
<imoveis>
    <imovel dataCriacao="01/01/1999">
        <anoConstrucao>2020</anoConstrucao>
        <contatoTelefone>11 99999-9999</contatoTelefone>
        <referencia>ABC00011</referencia>
        <!-- Pode ser ['Casa', 'Apartamento', 'Loja', 'Cobertura'] -->
        <tipoImovel>Casa</tipoImovel>
        <!-- Pode ser ['Venda', 'Locação', 'Venda e Locação'] -->
        <disponibilidade>Venda</disponibilidade>
        <valorVenda>R$ 300.000,00</valorVenda>
        <valorLocacao>R$ 0,00</valorLocacao>
        <enderecoRua>Rua 1</enderecoRua>
        <enderecoNumero>99</enderecoNumero>
        <enderecoComplemento>Casa 10</enderecoComplemento>
        <enderecoBairro>Bairro 1</enderecoBairro>
        <enderecoCidade>Cidade 1</enderecoCidade>
        <enderecoEstado>Estado 1</enderecoEstado>
        <enderecoPais>Brasil</enderecoPais>
        <enderecoCEP>00000-000</enderecoCEP>
    </imovel>
</imoveis>
```
