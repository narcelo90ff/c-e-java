using System;
using System.Collections.Generic;
using System.Linq;

public class Cliente
    {
        public int Id { get; set; }
        public string Nome { get; set; }
        public string Email { get; set; }
    }

    public class ClienteService
    {
        private List<Cliente> _clientes = new List<Cliente>();

        public void Salvar(Cliente c)
        {
            // Tarefa: Validar email antes de salvar
            if (string.IsNullOrWhiteSpace(c.Email) || !c.Email.Contains("@"))
            {
                Console.WriteLine($"Erro: Email '{c.Email}' inválido para o cliente {c.Nome}.");
                return;
            }
            _clientes.Add(c);
        }

        // Desafio: Buscar cliente por email
        public Cliente BuscarPorEmail(string email) 
            => _clientes.FirstOrDefault(cli => cli.Email.Equals(email, StringComparison.OrdinalIgnoreCase));
    }
