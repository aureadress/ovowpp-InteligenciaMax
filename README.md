# 🧠 Projeto MAX Ovowpp — Inteligência Laravel

Este projeto é parte do sistema **Ovowpp Inteligência Max**, desenvolvido em **Laravel**, com foco em automação e integração inteligente entre módulos.

---

## 🚀 Como Rodar o Projeto Localmente

### Pré-requisitos
- PHP 8.1+
- Composer
- MySQL
- Git

### Passos para Instalação

1. **Clonar o repositório**
   ```bash
   git clone https://github.com/aureadress/ovowpp-InteligenciaMax.git
   cd ovowpp-InteligenciaMax
   ```

2. **Instalar as dependências**
   ```bash
   composer install
   ```

3. **Configurar o ambiente**
   ```bash
   cp .env.example .env
   ```
   Ajuste as variáveis no arquivo `.env` conforme o seu banco de dados.

4. **Gerar a chave da aplicação**
   ```bash
   php artisan key:generate
   ```

5. **Executar as migrações**
   ```bash
   php artisan migrate --seed
   ```

6. **Rodar o servidor**
   ```bash
   php artisan serve
   ```
   O sistema estará disponível em:  
   👉 [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## 📁 Estrutura do Projeto

```
├── Documentation/       # Documentações do sistema
├── Laravel/             # Código-fonte principal (Laravel)
├── Updates/             # Atualizações e versões incrementais
└── README.md            # Documento atual
```

---

## 🧰 Principais Comandos Úteis

| Ação | Comando |
|------|----------|
| Rodar servidor local | `php artisan serve` |
| Limpar cache | `php artisan cache:clear` |
| Rodar migrações | `php artisan migrate` |
| Popular o banco com dados de teste | `php artisan db:seed` |

---

## 🧑‍💻 Autor
**AUREA DRESS**  
Projeto privado de inteligência e automação Ovowpp.  
> Repositório exclusivo e mantido pela equipe interna.

---

## 🛡️ Licença
Este projeto é de uso interno e não possui licença pública.
