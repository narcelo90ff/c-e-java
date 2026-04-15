using System;
using System.Collections.Generic;
using System.Linq;

// --- MODELO ---
public class Cliente
{
    public int Id { get; set; }
    public string Nome { get; set; }
    public string Email { get; set; }
}

// --- SERVIÇO (CRUD + VALIDAÇÃO) ---
public class ClienteService
{
    private List<Cliente> _clientes = new List<Cliente>();

    // TAREFA: Implementar CRUD com Validação de Email
    public void Criar(Cliente cliente)
    {
        // TAREFA: Validar email antes de salvar
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

// --- EXECUÇÃO (MAIN) ---
class Program
{
    static void Main()
    {
        var service = new ClienteService();

        // Testando inserções
        service.Criar(new Cliente { Id = 1, Nome = "Alice", Email = "alice@tech.com" });
        service.Criar(new Cliente { Id = 2, Nome = "Bob", Email = "bob_sem_arroba.com" }); // Deve falhar
        service.Criar(new Cliente { Id = 3, Nome = "Charlie", Email = "charlie@dev.com" });

        // TAREFA: Listar Clientes
        Console.WriteLine("\n--- Lista de Clientes Ativos ---");
        foreach (var c in service.ListarTodos())
        {
            Console.WriteLine($"ID: {c.Id} | Nome: {c.Nome} | Email: {c.Email}");
        }

        // DESAFIO: Buscar por Email
        Console.WriteLine("\n--- Teste de Busca (Desafio) ---");
        string emailBusca = "charlie@dev.com";
        var encontrado = service.BuscarPorEmail(emailBusca);

        if (encontrado != null)
            Console.WriteLine($"Encontrado: {encontrado.Nome} (ID: {
