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

    public void Criar(Cliente cliente)
    {
        if (string.IsNullOrWhiteSpace(cliente.Email) || !cliente.Email.Contains("@"))
        {
            Console.WriteLine($"[ERRO] Falha ao cadastrar {cliente.Nome}: E-mail inválido.");
            return;
        }

        _clientes.Add(cliente);
        Console.WriteLine($"[SUCESSO] Cliente {cliente.Nome} cadastrado!");
    }

    public List<Cliente> ListarTodos() => _clientes;

    public void Atualizar(int id, Cliente clienteAtualizado)
    {
        var existente = _clientes.FirstOrDefault(c => c.Id == id);
        if (existente != null && clienteAtualizado.Email.Contains("@"))
        {
            existente.Nome = clienteAtualizado.Nome;
            existente.Email = clienteAtualizado.Email;
        }
    }

    public void Deletar(int id) => _clientes.RemoveAll(c => c.Id == id);

    // DESAFIO: Buscar cliente por email
    public Cliente BuscarPorEmail(string email)
    {
        return _clientes.FirstOrDefault(c => 
            c.Email.Equals(email, StringComparison.OrdinalIgnoreCase));
    }
}

class Program
{
    static void Main()
    {
        var service = new ClienteService();

        service.Criar(new Cliente { Id = 1, Nome = "Alice", Email = "alice@tech.com" });
        service.Criar(new Cliente { Id = 2, Nome = "Bob", Email = "bob_sem_arroba.com" }); // Deve falhar
        service.Criar(new Cliente { Id = 3, Nome = "Charlie", Email = "charlie@dev.com" });

        Console.WriteLine("\n--- Lista de Clientes Ativos ---");
        foreach (var c in service.ListarTodos())
        {
            Console.WriteLine($"ID: {c.Id} | Nome: {c.Nome} | Email: {c.Email}");
        }

        Console.WriteLine("\n--- Teste de Busca (Desafio) ---");
        string emailBusca = "charlie@dev.com";
        var encontrado = service.BuscarPorEmail(emailBusca);

        if (encontrado != null)
            Console.WriteLine($"Encontrado: {encontrado.Nome} (ID: {
